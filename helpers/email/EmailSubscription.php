<?php

namespace Helpers\Email;
// https://github.com/PHPMailer/PHPMailer

// require '../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



class EmailSubscription extends Email {
    private $subject = 'Registrazione';
    private $buttonTpl = 'Verifica indirizzo email';

    // variabili per il template/body dell' email
    private $template = 'email';

    // Variabili per il template dell'email
    // public $site;
    public $titleTpl = 'Verifica il tuo indirizzo email1';
    public $info1Tpl = 'Per iniziare ad usare il tuo account devi confermare l\'indirizzo email';
    public $info2Tpl = 'Se non sei stato tu ad ad iscriverti, ignora questa email. L\' account verrà chiuso.';
    public $info3Tpl = 'Se il bottone non funziona copia il link qui sotto e incollalo nel URL del tuo browser';
    public $info4Tpl = 'Scarica l\'ultima app per il tuo smartphone';

    public $link;
    // background color
    public $bgColor1 = '#ddd';
    public $bgColor2 = '#fff';
    // text color
    public $txtColor1 = '#333';
    public $txtColor2 = '#000';
    // button bg color
    public $btnBgColor1 = '#007BFF';
    public $btnBgColor2 = '#0069d9'; // hover
    // button text color
    public $btnTxtColor1 = '#ddd';
    public $btnTxtColor2 = '#fff'; // hover

    // public function __construct(string $name, string $email, string $hash){
    public function __construct(array $user){

        $name = $user['name'];
        $email = $user['email'];
        $hash = $user['hashEmail'];

        parent::__construct($name, $email);

        $route = '/auth/signup/verify/';
        //$route = "/login-system/src/controller/registration.php/"; //  http://localhost/login-system/src/controller/registration.php
        $this->link = $this->site.$route.'?email='.$email.'&hashEmail='.$hash; //http://localhost:3000/auth/verify/?email=dmanzi83@hotmail.it&hash=a597e50502f5ff68e3e25b9114205d4a
        // $this->link = $this->site.$route."?email=".$email."&hash=".$hash; //http://localhost:3000/auth/verify/?email=dmanzi83@hotmail.it&hash=a597e50502f5ff68e3e25b9114205d4a
        // http://localhost/login-system/src/controller/signup.phpsrc/controller/registration.php?email=dan@mail.it&hash=3621f1454cacf995530ea53652ddf8fb
    }




    /**
     * email che viene inviata in fase di registrazione dell' utente
     * oppure quando l' account dell' utente non è ancora stato attivato
     * EMAIL INVIO [GMAIL]    https://support.google.com/a/answer/176600?hl=it
     * @param boolean $test
     * @return void
     */
    public function send_($test=true) {
        $mail = new PHPMailer(true);                                         // Passing `true` enables exceptions

        $mail->SMTPDebug = 0;                                               // Enable verbose debug output
        $mail->isSMTP();                                                    // Set mailer to use SMTP
        $mail->Host = $test ? 'smtp.mailtrap.io' : 'smtp.gmail.com';        // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                                             // Enable SMTP authentication
        $mail->Username = $test ? 'b34b7169adb122' : 'dmanzi83@gmail.com';  // dmanzi83@gmail.com   // SMTP username
        $mail->Password = $test ? '8d0c925142f07b' : '**********';          // mia password google  // SMTP password
        $mail->SMTPSecure = 'tls';                                          // Enable TLS encryption, `ssl` also accepted
        $mail->Port =  $test ? 465 : 587;
        //Recipients
        $mail->setFrom($this->emailSender, $this->nameSender);              // mittente email e nome
        $mail->addAddress($this->emailRecipient, $this->nameRecipient);     // destinatario email e nome
        //Content
        $mail->isHTML(true);                                                // Set email format to HTML
        $mail->Subject = $this->subject;                                    // Benvenuto in danielemanzi.it // Account su danielemanzi.it cancellato // Crea una nuova password

        if( file_exists('../../views/desktop/view-email/'.$this->template.'.tpl.php') ) {
            $body = require '../../views/desktop/view-email/'.$this->template.'.tpl.php';
        } else { $body = "<h1>Email Inviata</h1>";   }
        $mail->Body = $body;                                                // $body = "<h1>Email Inviata</h1>";
        $mail->AltBody = strip_tags($body);

        $mail->send();
    }





/**
 * [MAILTRAP]
 * Invia email di registrazione/sottoscrizione dell'account.
 * [a1] Istanzia la classe PHPMailer. Passando `true` come parametro abilita le eccezioni.
 * [a2] Enable verbose debug output.
 * [a3] Set mailer to use SMTP.
 * [a4] Specify main and backup SMTP servers.
 * [a5] Enable SMTP authentication.
 * [a6] SMTP username. In sviluppo la username di mailtrap. In produzione inserire la propia email (es.: dmanzi83@gmail.com).
 * [a7] SMTP password. In sviluppo la password di mailtrap. In produzione inserire la propia password.
 * [a8] Enable TLS encryption, `ssl` also accepted.
 * [a9] In sviluppo inserire la porta 465 o 2525. In produzione inserire la porta 587.
 * [a10] Sender/Mittente il proprietario dell'app/sitoweb/software.
 * In questo caso: nameSender = 'Daniele Manzi'; emailSender = 'dmanzi83@gmail.com'; (vedi classe madre Email).
 * [a11] Recipients/Destinatario l'utente che riceve l'email per registrarsi/sottoscriversi al sito.
 * [a12] Set email format to HTML.
 * [a13] Oggetto dell'email. In questo caso è: 'Registrazione' ma è un valore da settare a piacere, es.:
 * 'Crea una nuova password' | 'Benvenuto in danielemanzi.it' | 'Account su danielemanzi.it cancellato' eccetera...
 * [a14] Percorso del template del corpo dell'email.
 * [a15] Setta il corpo dell' email.
 * [a16] ...
 * [a17] Invia l'email.
 * @return void
 */
public function send() {
    $mail = new PHPMailer(true); // [a1]
    $mail->SMTPDebug = 0; // [a2]
    $mail->isSMTP(); // [a3]
    $mail->Host = 'smtp.mailtrap.io'; // [a4]
    $mail->SMTPAuth = true; // [a5]
    $mail->Username = 'b34b7169adb122'; // [a6]
    $mail->Password = '8d0c925142f07b'; // [a7]
    $mail->SMTPSecure = 'tls'; // [a8]
    $mail->Port = 2525; // [a9]
    $mail->setFrom($this->emailSender, $this->nameSender); // [a10]
    $mail->addAddress($this->emailRecipient, $this->nameRecipient); // [a11]
    //Content
    $mail->isHTML(true); // [a12]
    $mail->Subject = $this->subject; // [a13]

    if (file_exists('app/views/desktop/view-email/'.$this->template.'.tpl.php')) { // [a14]
        $body = require 'app/views/desktop/view-email/'.$this->template.'.tpl.php';
    } else { $body = "<h1>Email Inviata</h1>"; }

    $mail->Body = $body; // [a15]
    $mail->AltBody = strip_tags($body); // [a16]

    $mail->send(); // [a17]
}



} // CHIUDE CLASSE








 /*******************************************************************************|
    *      |
    ********************************************************************************/
    /*
    public function sendZ(){
        $mail = new PHPMailer(true);
        try { //Server settings
        //  GMAIL SMTP (simple mail transfer protocol)
        $mail->SMTPDebug = 0;                       // Enable verbose debug output
        $mail->isSMTP();                            // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';             // Server di posta in uscita(SMTP)
        $mail->SMTPAuth = true;                     // Enable SMTP authentication
        $mail->Username = 'dmanzi83@gmail.com';     // SMTP username                            //[mailtrap: 'b34b7169adb122']
        $mail->Password = '**********';             // SMTP password                            //[mailtrap: '8d0c925142f07b']
        $mail->SMTPSecure = 'tls';                  // attiva 'tls' per porta '587' oppure `ssl` per porta '465'
        $mail->Port = 587;                          // TCP port to connect to                   //[mailtrap: 465]
        //Recipients
        $mail->setFrom($this->emailSender, $this->nameSender);          // mittente email e nome
        $mail->addAddress($this->emailRecipient, $this->nameRecipient); // destinatario email e nome
        //Content
        $mail->isHTML(true);
        $mail->Subject = $this->subject;
        $body = require 'layout/'.$this->template.'.tpl.php';  // 'layout\\'.$this->template.'.tpl.php';
        $mail->Body = $body;
        $mail->AltBody = strip_tags($body);
        $mail->send();
    //    } catch (Exception $e) {
          //  echo 'Invio email fallito! Errore: ', $mail->ErrorInfo;
     //   }
    }
*/
