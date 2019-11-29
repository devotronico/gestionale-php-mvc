<?php

namespace App\Controllers;

use PDO;
use App\Models\Signup;
use App\Models\SignupConfirm;
use App\Models\Image;
use Helpers\Validation;
use Exception;
use Helpers\Email\EmailSubscription;
use Helpers\Log;


class SignupController extends Controller
{
    protected $bytes = 500000;

    public function __construct(PDO $conn) {
        parent::__construct();
        $this->conn = $conn;
        $this->page = 'signup';
    }


/**
 * * SIGNUP FORM       metodo = GET   route = auth/signup/form
 * Al click sul navlink con Label 'signup' che sta nella Navbar
 * carica il template del form per fare la registrazione
 * [a1] La variabile **page** serve per caricare il file css specifico per questo form (solo?)
 * ? [a2] la variabile $navlink è da capire a che serve e se serve (sembra non utilizzata)
 * Al submit del form viene attivato il metodo 'signupStore'
 * @return void
 */
public function form() {
    $navlink = 'signup'; // [a2]
    $acceptFileType = '.jpg, .jpeg, .png';
    $bytes = $this->bytes;
    $megabytes = $bytes * 0.000001;
    $files = ['navbar', 'signup.form'];
    $this->content = view($this->device, 'auth', $files, compact('navlink', 'acceptFileType', 'bytes', 'megabytes'));
}


public function store() {
    $obj = json_decode($_POST['data']);

    $validation = new Validation($obj);

    if (!$validation->validate()) { throw new Exception($validation->getAllErrors(), -15, null); }

    $Signup = new Signup($this->conn, $obj); // [b2]

    $userData = $Signup->signup();

    // if (!class_exists('EmailSubscription')) { throw new MyException('Errore: classe EmailSubscription non trovata', -20, null, 'php', $this->page); }
    $emailSubscription = new EmailSubscription($userData);
    $emailSubscription->send();

    $time = date("YmdHis");
    $data['head'] = ['date'=> $time, 'status'=> 'success', 'code'=> 10, 'request'=> 'async', 'section'=> 'auth', 'action'=> 'signup-store'];
    $data['body'] = ['dom'=> 'signup', 'message'=> 'Per completare la registrazione ti è stata inviata un\' email al tuo indirizzo ' .$obj->email . ', aprila e clicca sul navlink all\' interno'];
    die(json_encode($data));

    /*
    $Signup->storeData('default.jpg'); // [b3]
    $message = "Abbiamo mandato una email di attivazione a <strong>".$_POST['email']."</strong><br>Per favore segui le istruzioni contenute nell'email per attivare il tuo account. Se l'email non ti arriva, controlla la tua cartella spam o prova a collegarti ancora per inviare un'altra email di attivazione.";
    $files=[$this->device.'.navbar', 'signup.success'];
    $this->content = view($this->device, 'auth', $files, compact('message'));
    */
}



    public function verify() {
        $this->page = 'signup';

        $validation = new Validation($_GET);

        if ($validation->validate()) {

        $signupConfirm = new SignupConfirm($this->conn, $_GET);
        $signupConfirm->getUserDataForSession();

        $message = 'Complimenti <strong>'.$_SESSION['user_name'].'</strong> la tua registrazione è avvenuta con successo!';
        $files = [$this->device.'.navbar', 'signup.verify'];
        $this->content = view($this->device, 'auth', $files, compact('message'));

        } else {
            $multimessageError = $validation->getAllErrors();
            throw new Exception($multimessageError, -15, null);
        }
    }


function getTemplate() {
    // $header = strtoupper($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '');
    // if ($header === 'XMLHTTPREQUEST') {
    //     echo '<h1>OK</h1>';
    // } else {
    //     echo '<h1>KO</h1>';
    // }
    // exit;

    // $content = get_content();
    $content = file_get_contents('layout\inc\signup-email.tpl.html');
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        die($content);
    } else {
        echo '<h1>KO</h1>';
    }

    exit;

//     OB_END_CLEAN
// $HEADER = STRTOUPPER $_SERVER['HTTP_X_REQUESTED_WITH']
// XMLHTTPREQUEST
}




//*******|*********|*********|*********|*********|*********|*********|*********|*********|*********|

/**
 * * SIGNUP STORE      metodo = POST    route = auth/signup/store
 *
 * // TODO: accorpare in un unica funzione i punti [b5] [c3] [c6]
 *
 * * [b1] SE durante la compilazione del form l'utente NON ha caricato un immagine:
 *    [b2] Saltano i controlli sull'immagine e viene istanziata direttamente la classe Signup
 *    passando nel costruttore l'array $_POST che contiene tutti i parametri che provengono
 *    dal form per registrali nella tabella `user` del database.
 *    [b3] Al metodo storeData viene passato il nome dell'immagine di default che viene
 *    salvata nel database per consentire all'utente di avere comunque un immagine di default.
 *    [b4] Se non si sono verificati errori viene caricato un template con un messaggio di
 *    successo che informa l'utente che gli è stata inviata una mail per attivare il suo account.
 *    [b5] se invece si sono verificati errori l'utente viene indirizzato di nuovo al form di
 *    registrazione che mostra un messaggio di errore.
 *
 * * [c1] SE durante la compilazione del form l'utente ha caricato un immagine
 *    [c2] Se l'inserimento dell'immagine ha avuto successo viene salvata una copia
 *    dell'immagine nella cartella public/img/auth
 *    [c3] In caso di errori nel caricamento dell'immagine...vedi [b5]
 *    [c4] Ora il sistema può procedere per verificare i restanti dati inseriti nel form.
 *    [c5] Se sono validi vengono salvati nel database insieme al nome dell'immagine inserita.
 *    [c6] Se non si sono verificati errori viene caricato un template con un messaggio di
 *    successo che informa l'utente che gli è stata inviata una mail per attivare il suo account.
 *    [c7] se invece si sono verificati errori...vedi [b5]
 * @return void
 */
/*
public function signupStore_old() {
    // die('{"test-1": "OK","signup": "OK"}');
    $this->page = 'signup';

    if ($_FILES['file']['error'] === 4) { // [b1]
        $Signup = new Signup($this->conn, $_POST); // [b2]
        $Signup->storeData('default.jpg'); // [b3]

        if (empty($Signup->getMessage())) { // [b4]
            $message = "Abbiamo mandato una email di attivazione a <strong>".$_POST['email']."</strong><br>Per favore segui le istruzioni contenute nell'email per attivare il tuo account. Se l'email non ti arriva, controlla la tua cartella spam o prova a collegarti ancora per inviare un'altra email di attivazione.";
            $files=[$this->device.'.navbar', 'signup.success'];
            $this->content = view($this->device, 'auth', $files, compact('message'));
        } else { // [b5]
            // $message = $Signup->getMessage();
            // $uri ='/auth/signup/form';
            // redirect($uri, $message);

            $navlink="signup";
            $message = $Signup->getMessage();
            $acceptFileType=".jpg, .jpeg, .png";
            $bytes = $this->bytes;
            $megabytes = $bytes * 0.000001;
            $files=[$this->device.'.navbar', 'signup.form'];
            $this->content = view($this->device, 'auth', $files, compact('navlink', 'message', 'acceptFileType', 'bytes', 'megabytes'));
        }
    } else {
        $Image = new Image('fixed', 92, 92, $this->bytes, 'auth', $_FILES);

        if (empty( $Image->getMessage())) { // [c2]
            $imageName = !is_null($Image->getNewImageName()) ? $Image->getNewImageName() : 'default.jpg';
            $Signup = new Signup($this->conn, $_POST); // [c4]
            $Signup->storeData($imageName); // [c5]

            if (empty($Signup->getMessage())) { // [c6]
                $message = "Abbiamo mandato una email di attivazione a <strong>".$_POST['email']."</strong><br>Per favore segui le istruzioni contenute nell'email per attivare il tuo account. Se l'email non ti arriva, controlla la tua cartella spam o prova a collegarti ancora per inviare un'altra email di attivazione.";
                $files=[$this->device.'.navbar', 'signup.success'];
                $this->content = view($this->device, 'auth', $files, compact('message'));
            } else { // [c7]
                $navlink="signup";
                $message = $Signup->getMessage();
                $acceptFileType=".jpg, .jpeg, .png";
                $bytes = $this->bytes;
                $megabytes = $bytes * 0.000001;
                $files=[$this->device.'.navbar', 'signup.form'];
                $this->content = view($this->device, 'auth', $files, compact('navlink', 'message', 'acceptFileType', 'bytes', 'megabytes'));
            }
        } else { // [c3]
            $navlink="signup";
            $message = $Image->getMessage();
            $acceptFileType=".jpg, .jpeg, .png";
            $bytes = $this->bytes;
            $megabytes = $bytes * 0.000001;
            $files=[$this->device.'.navbar', 'signup.form'];
            $this->content = view($this->device, 'auth', $files, compact('navlink', 'message', 'acceptFileType', 'bytes', 'megabytes'));
        }
    }
}
*/


//*******|*********|*********|*********|*********|*********|*********|*********|*********|*********|

/**
 * * SIGNUP VERIFY     metodo = GET   route = auth/signup/verify    COOKIE
 * // TODO: gestire il caso in cui si verifica un errore
 * [d1] Quando l'utente apre l'email che il sistema gli ha inviato,
 * e clicca all'interno della mail il navlink/bottone viene indirizzato di nuovo sul gestionale.
 * Il navlink cliccato contiene parametri univoci necessari per attivare il suo account.
 * [d2] I parametri/variabili si trovano nell'array $_GET che viene passato insieme
 * alla connessione al database nel costruttore della classe SignupConfirm.
 * [d3] Se la verifica e salvataggio dei parametri nel database non ha generato errori e
 * se l'account non era già stato attivato,
 * l'account viene attivato e l'utente viene loggato e indirizzato in una pagina di benvenuto
 * @return void
 */
/*
public function signupVerify() {
    $this->page = 'signup';
    $SignupConfirm = new SignupConfirm($this->conn, $_GET); // [d2]
    $SignupConfirm->accountActivation(); // [d3]
    $message = !empty($SignupConfirm->getMessage()) ? $SignupConfirm->getMessage() : "Complimenti <strong>".$_SESSION['user_name']."</strong> la tua registrazione è avvenuta con successo!";
    $files=[$this->device.'.navbar', 'signup.verify'];
    $this->content = view($this->device, 'auth', $files, compact('message'));
}
*/


} // chiude SignupController
