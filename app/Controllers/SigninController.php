<?php
namespace App\Controllers;

use PDO;
use App\Models\Signin;
use Helpers\Validation;
use Exception;



class SigninController extends Controller
{

    public function __construct(PDO $conn) {
        parent::__construct();
        $this->conn = $conn;
    }

    /**
     * Genera Token CSRF
     * Esempio di possibile valore del token
     * $token = 649315747a2e15e0f916d63a4b4949e99f2fcb3ba09503ed3b2fd97ddaf10f47
     * Note: al link https://www.php.net/manual/en/function.random-bytes.php
     * c'è un esempio migliore per generare un token CSRF
     * @return string
     */
    private function generateToken() {
        $bytes = random_bytes(32);
        $token = bin2hex($bytes);
        $_SESSION['csrf'] = $token;
        return $token;
    }


    /**
     * * SIGNIN FORM       metodo = GET      route = ['', '/', 'auth/signin/form']
     * Carica il template del form per fare il login
     * Inietta il token csrf nel template del form in un campo input hidden
     * @return void
     */
    public function signinForm() {
        $this->page = 'signin';
        $files = ['navbar', 'signin.form'];
        $navlink = 'signin';
        $token = $this->generateToken();
        $this->content = view($this->device, 'auth', $files, compact('navlink', 'token'));
    }


/**
 * * SIGNIN ACCESS     metodo = POST    route = 'auth/signin/access'       $_COOKIE
 * Questo metodo controlla l'email e la password che sono stati inseriti nel form del login
 * [a] Se sono corretti allora si viene indirizzati nella pagina di benvenuto
 * [b] Altrimenti se sono errati si rimane nella pagina del login con un messaggio di errore
 * [c] Se si prova a loggare senza aver prima attivato l'account dalla mail che ci ha inviato il
 *     sistema durante la fase di registrazione
 *     allora il sistema ci invierà un'altra mail chiedendoci di attivare l'account
 * @return void
 */
public function signinAccess() {

    $obj = json_decode($_POST['data']);
    // $test = 'ciao'; // DEBUG
    // if ($test !== $_SESSION['csrf']) { throw new Exception('Attacco csrf', -40); } // DEBUG
    if (!$obj->token === $_SESSION['csrf']) { throw new Exception('Attacco csrf', -15); }
    $validation = new Validation($obj);
    if (!$validation->validate()) { throw new Exception($validation->getAllErrors(), -15); }

    $this->page = 'signin';
    $Signin = new Signin($this->conn, $obj);

    $userData = $Signin->login();

    $time = date('YmdHis');

    $data['head'] = ['date'=> $time, 'status'=> 'success', 'code'=> 10, 'section'=> 'auth', 'action'=> 'signin'];
    $data['body'] = ['id'=> $userData['id'], 'name'=> $userData['name'], 'message'=> 'Login avvenuto con successo'];
    die(json_encode($data));
/*
    if (empty($Signin->getMessage())) {
        $email = $Signin->login();
        if (empty( $Signin->getMessage())) {
            if (isset($_SESSION['user_id'])):
                $message = "Login riuscito";
                $files=[$this->device.'.navbar', 'signin.message'];
                $this->content = view($this->device, 'auth', $files, compact('message')); // [a]
            else:
                $files=[$this->device.'.navbar', 'signin.message'];
                $this->content = view($this->device, 'auth', $files, compact('email')); // [a]
            endif;
        } else { // [b]
            $message = $Signin->getMessage();
            $files=[$this->device.'.navbar', 'signin.form'];
            $link="signin";
            $this->content = view($this->device, 'auth', $files, compact('link', 'message')); // [c]
        }
    } else { // [b]
        $message = $Signin->getMessage();
        $files=[$this->device.'.navbar', 'signin.form'];
        $link="signin";
        $this->content = view($this->device, 'auth', $files, compact('link', 'message')); // [c]
    }
    */

}

/***************************************************************************************************|
* LOGOUT    metodo = GET    route = auth/logout                                                     |
* distruggiamo l'id della sessione e il valore di $_SESSION["user_id"] e $_SESSION['role']     |
* e distruggiamo il COOKIE                                                                          |
****************************************************************************************************/
public function logout(){
    if (session_status() == PHP_SESSION_ACTIVE) { 
        session_destroy();  
        session_unset();
        $_SESSION = []; // OK
    }
    //setcookie("user_id", null);
    setcookie("user_id", null, time()-3600, '/');
    redirect("/");
}


} // CHIUDE LA CLASSE
