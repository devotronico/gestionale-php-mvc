<?php

namespace App\Models;
use PDO;
use Exception;

/**
 * Quando nell'email viene cliccato sul link di conferma per attivare l'account si viene indirizzati di nuovo sul sito
 * Il link contiene le variabili/parametri $_GET['email'] e $_GET['hash']
 * Dopo aver validato con la classe Validation l'email e l'hash che sono stati passati dall'url col metodo GET
 * Viene richiamata questa classe per confrontari i valori $_GET['email'] e $_GET['hash'] con quelli presenti nel database
 */
class SignupConfirm
{
    private $conn;
    private $message;
    private $email;
    private $hash;
    public function __construct(PDO $conn, array $data = [])
    {
        $this->conn = $conn;
        $this->email = $data['email'];
        $this->hash = $data['hashEmail'];

        if ($hashDatabase = $this->isEmailAlreadyStored()) {
            if ($this->isNotAlreadyActivated()) {
                if ($hashDatabase !== $data['hashEmail']) { throw new Exception('Il parametro hash è errato.', -10); }
                $this->activateAccount();
            }
        }
    }



    /**
     * IS EMAIL ALREADY STORED
     * Controlla se l'email è già presente nel database
     * Se lo è, allora ritorna il valore dell' hash corrispondete a questa email
     * @param string $email
     * @return string - ritorna l'hash memorizzata nel database
     */
    private function isEmailAlreadyStored() {
        $sql = "SELECT hash_email FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
        if (!$stmt->execute()) { throw new Exception('Errore: mysqli::execute', -30);}
        if ($stmt->rowCount() !== 1) { throw new Exception('L\' email <strong>'.$this->email.'</strong> non è stata ancora registrata.', -10);}
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) { throw new Exception('Errore: mysqli::fetch', -30); }
        $stmt = null;
        return $user['hash_email'];
    }

    /**
     * is Account Already Activated
     * Controlla se l'account è stato già precedentemente attivato.
     * In questa fase l'account non dovrebbe essere già stato attivato.
     * Se l'account Non è stato ancora attivato il campo 'verified'
     * è uguale a 0 altrimenti è uguale a 1 altrimenti.
     * Se 'verified' è uguale a 0:
     * 1. Se l'email utilizzata per fare la select NON è la stessa presente nella tabella
     * ritorna NULL
     * 2. Se l'email utilizzata per fare la select è la stessa presente nella tabella
     * allora ritorna il valore del campo `hash_email`
     *
     *
     * @return string - ritorna il codice hash del campo `hash_email`
     */
    private function isNotAlreadyActivated() {
        $sql = "SELECT hash_email, verified FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
        if (!$stmt->execute()) { throw new Exception('Errore: mysqli::execute', -30); }
        if ($stmt->fetch(PDO::FETCH_ASSOC)['verified'] === '1') { throw new Exception('Questo account è già stato attivato.', -10); }
        $stmt = null;
        return true;
    }

    private function activateAccount() {
        $sql = "UPDATE users SET verified = 1 WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
        if (!$stmt->execute()) { throw new Exception('Errore: mysqli::execute', -30); }
        $stmt = null;
    }


    public function getUserDataForSession() {
        $sql = "SELECT id, role, name FROM users WHERE email = :email";
        if (!$stmt = $this->conn->prepare($sql)) { throw new MyException(['type' => 'database', 'message' => 'Errore: mysqli::prepare'], -30, null, 'sync', 'auth', 'signup-verify'); }
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
        if (!$stmt->execute()) { throw new MyException(['type' => 'database', 'message' => 'Errore: mysqli::execute'], -30, null, 'auth', 'signup'); }
        if (!$user = $stmt->fetch(PDO::FETCH_ASSOC)) { throw new MyException(['type' => 'database', 'message' => 'Errore: mysqli::fetch'], -30, null, 'sync', 'auth', 'signup-verify'); }
        $stmt = null;
        $this->conn = null;
        return $user;
    }


/***************************************************************************************************************************|
 * Email ACTIVATION      [set cookie]    SIGNUP                                                                             |

 * Controlliamo se corrispondo ai valori presenti nella tabella 'users' del database                                        |
 * Se sono uguali allora settiamo le variabili globali SESSION e COOKIE                                                     |
 * Poi facciamo un controllo sul campo 'role'                                                                        |
 * Se il valore di 'role' è uguale a 0:                                                                              |
 *  cambiamo il suo valore in 1. il valore 1 sta a indicare che la registrazione al sito è completa.                        |
 * Se il valore di 'role' è uguale a 1:                                                                              |
 *  lasciamo il suo valore in 1. vuol dire che questo account era già stato attivato precedentemente                        |
 ***************************************************************************************************************************/
/*
public function accountActivation() {
$sql = "SELECT id, role, name, hash_email, verified FROM users WHERE email = :email";
if (!$stmt = $this->conn->prepare($sql)) { throw new MyException(['type' => 'database', 'message' => 'Errore: mysqli::prepare'], -30, null, 'auth', 'signup-verify'); }
$stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
if (!$stmt->execute()) { throw new MyException(['type' => 'database', 'message' => 'Errore: mysqli::execute'], -30, null, 'auth', 'signup'); }
if ($stmt->rowCount() !== 1) { throw new MyException(['type' => 'email', 'message' => 'Il parametro email è errato.'], -10, null, 'auth', 'signup-verify'); }

$user = $stmt->fetch(PDO::FETCH_ASSOC);
if ($user['hash_email'] !== $this->hash) { throw new MyException(['type' => 'hash', 'message' => 'Il parametro hash è errato.'], -10, null, 'auth', 'signup-verify'); }

$_SESSION['user_id'] = $user['id'];
$_SESSION['role'] = $user['role'];
$_SESSION['user_name'] = $user['name'];
setcookie("user_id", $user['id'], time()+3600, '/');
if ($user['verified'] === 1) { throw new MyException(['type' => 'verified', 'message' => 'Questo account è già stato attivato.'], -10, null, 'auth', 'signup-verify'); }
$sql = "UPDATE users SET verified = 1 WHERE email = :email";
if (!$stmt = $this->conn->prepare($sql)) { throw new MyException(['type' => 'database', 'message' => 'Errore: mysqli::prepare'], -30, null, 'auth', 'signup-verify'); }
$stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
if (!$stmt->execute()) { throw new MyException(['type' => 'database', 'message' => 'Errore: mysqli::execute'], -30, null, 'auth', 'signup'); }

$stmt = null;
$this->conn = null;
}
*/





//==========================================================================================================================
/***************************************************************************************************************************|
 * EMAIL LINK                                  PASSWORD                                                                     |
 * Quando  nell'email clicchiamo sul link di conferma per attivare l'account presente verremo indirizzati di nuovo sul sito |
 * Il link contiene le variabili/parametri $_GET['email'] e $_GET['hash']                                                   |
 * Dopo aver validato la email e la hash che sono stati passati dall'url col metodo GET                                     |
 * Controlliamo se corrispondo ai valori presenti nella tabella 'users' del database                                        |
 * Se sono uguali allora facciamo un controllo sul campo 'role'                                                      |
 * Se il valore di 'role' è uguale a 0:                                                                              |
 *  cambiamo il suo valore in 1. il valore 1 sta a indicare che la registrazione al sito è completa.                        |
 * Se il valore di 'role' è uguale a 1:                                                                              |
 *  lasciamo il suo valore in 1. vuol dire che questo account era già stato attivato precedentemente                        |
 ***************************************************************************************************************************/
public function linkNewPass()
{
    if (!empty($this->message)) {exit;}

        $email = $this->email;
        $hash = $this->hash;
        $sql = "SELECT user_activation_key, role FROM users WHERE user_email = :email";
        if ($stmt = $this->conn->prepare($sql))
        {
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);

            if ($stmt->execute())
            {
                if ($stmt->rowCount() == 1)
                {
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ( $user['user_activation_key'] === $this->hash )
                    {
                        if ( $user['role'] == 0 ) {
                            $sql = "UPDATE users SET role = 1 WHERE user_email = :email";
                            if ($stmt = $this->conn->prepare($sql))
                            {
                                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);

                                $this->message .= $stmt->execute() ? '' : "Qualcosa è andato storto. Per favore prova più tardi.";
                            } else { $this->message .= "Qualcosa è andato storto. Per favore prova più tardi.";}
                        } // else { $this->message .= '';}
                    } else { $this->message = "Il parametro hash è errato";}
                } else { $this->message = "Il parametro email è errato";}
            } else { $this->message .= "Qualcosa è andato storto. Per favore prova più tardi.";}
        } else { $this->message .= "Qualcosa è andato storto. Per favore prova più tardi.";}
        $stmt = null;
        $this->conn = null;
}
/*****************************************VALIDAZIONI*******************************************************************************/





    /*******************************************************************************************************|
     * IS HASH STORED                                                                                       |
     * Controlla se l' hash è già presente nel database                                                     |
     * Se lo è, allora la ritorna                                                                           |
     *******************************************************************************************************/
/*
    private function isHashStored($hash) {
        if ( $hash ) {
                $sql = "SELECT user_activation_key FROM users WHERE user_activation_key = :hash";
                if ($stmt = $this->conn->prepare($sql))
                {
                    $stmt->bindParam(':hash', $hash, PDO::PARAM_STR, 32);
                    if ($stmt->execute())
                    {
                        if ($stmt->rowCount() == 1) {
                            $user = [];
                            $user = $stmt->fetch(PDO::FETCH_ASSOC);
                            $stmt = null;
                            return $user['user_activation_key'];
                        } else {
                            $this->message .= "Questa hash <strong>".$hash."</strong> non è presente nel database.<br>";
                        }
                    } else {
                        $this->message .= "Qualcosa è andato storto. Per favore prova più tardi.";
                    }
                } else {
                    $this->message .= "Qualcosa è andato storto. Per favore prova più tardi.";
                }
                $stmt = null;
            } else {
                $this->message .= "il parametro hash è vuoto";
            }
        }
        */
} // Chiude la classe SignupConfirm


/***************************************************************************************************************|
 * GET MESSAGE                                                                                                  |
 * Ritorna eventuali messaggi errori da utilizzare se un determinata richiesta dell'utente è andata a buon fine |
 ***************************************************************************************************************/
/*
public function getMessage() {
    return $this->message;
}
*/

/***************************************************************************************************|
 * VALIDATE EMAIL BASE                                                                              |
 * fa una prima validificazione del 'email                                                          |
 * Controlla: che non sia vuota e che abbia caratteri validi                                        |
 * FILTER_SANITIZE_EMAIL                                                                            |
 * Rimuove tutti i caratteri eccetto le lettere, i numeri e i caratteri !#$%&'*+-/=?^_`{|}~@.[]     |
 * Non sono considerate valide le email con i caratteri "\<>                                        |
 * ma lascia le virgolette singole ['] perciò non è sufficiente.                                    |
 * Se l'email contiene il carattere '/' verrà ritenuta valida ma il carattere '/' verrà rimosso     |
 * HTML5 non considera valide le email con i caratteri:                                             |
 *  prima e dopo la chiocciola  @()[]:<>\"                                                          |
 *  prima della chiocciola      @()[]:<>\"                                                          |
 *  dopo la chiocciola          @$%&'*+/=?^_`{|}~()[]:<>\"                                          |
 ***************************************************************************************************/
/*
private function validateEmail($email) {
    $email = trim($email);
    if ( empty($email) ) {
        $this->message .= "Il campo email è vuoto.<br>";
    } else {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if ($email === false) {
            $this->message .= "<strong>".$email."</strong> non è un email valida.<br>";
        } else {
            return $email;
        }
    }
}
*/

/***************************************************************************************************|
 * HASH URL VALIDATE                                                                                |
 * Controlla se sono validi i caratteri che compongono l' hash che otteniamo dall' url [metodo GET] |
 ***************************************************************************************************/
/*
private function hashUrlValidate($hash) {
    if (preg_match('/^[a-f0-9]{32}$/', $hash)) {
        return $hash;
    } else {
        $this->message .= "il parametro hash non è valido";
    }
}
*/