<?php
namespace App\Models;

use PDO;
use Exception;
use Helpers\Email\EmailSubscription;
use Helpers\Sessions;


class Signin
{
    private $conn;
    private $email;
    private $password;
    private $message;

    public function __construct(PDO $conn, object $obj) {

        $this->conn = $conn;
        $this->email = $obj->email;
        $this->password = $obj->password;
        // $this->name = $obj->name;


        // $this->conn = $conn;
        // $this->email = isset($data['email'])? $this->validateEmail($data['email']): null;
        // $this->password = isset($data['password'])? $this->validatePass($data['password']): null;
    }



//*******|*********|*********|*********|*********|*********|*********|*********|*********|*********|
    /**
     * * LOGIN   [set cookie]
     * dopo aver precedentemente validato email e password controlla se
     * entrambi i valori esistono nel database.
     * [a] Utilizzando l'email per fare la query estrae il valore della password dal database.
     * [b] Se nella tabella `users` del database c'è una row che ha il campo `email`
     *     valorizzato con la stessa email inserita nel form del login, allora
     * [c] controlla se sono uguali la password inserita nel form con quella del database
     *     Se le password sono uguali fa un altro controllo sul campo 'verified'
     * [d] Se 'verified' è uguale a 1:
     *     significa che l'account è già stato attivato precedentemente dall'email che il sistema
     *     ha inviato all'utente nel momento della registrazione.
     * [e] Quindi appurato che i dati inseriti nel form sono validi e
     *     che appartengono a un utente già registrato e
     *     che il suo account è stato attivato,
     *     solo a questo punto vengono settate le variabili di sessione e un cookie
     * [f] Se 'verified' è uguale a 0:
     *     allora non potremo loggarci e il sistema ci invierà una mail per attivare il l'account
     * @return void
     */
    public function login() {
        $sql = 'SELECT id, roletype, name, password, hash_email, verified FROM users WHERE email = :email'; // [a]
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
        $stmt->execute();
        if ($stmt->rowCount() != 1) { throw new Exception('All\' email <strong>'. $this->email .'</strong> non risulta associato nessun account.', -10);} // [b]
        $user = [];
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!password_verify($this->password, $user['password'])) { throw new Exception('La password inserita non corrisponde all\' email', -11);} // [c]
        if ($user['verified'] == 1) { // [d]
            Sessions::setSession($user);
            return ['id' => $user['id'], 'name' => $user['name']];
        } else {
            $userData = ['name' => $user['name'], 'email' => $this->email, 'hashEmail' => $user['hash_email']];
            $emailSubscription = new EmailSubscription($userData);
            $emailSubscription->send();
            $time = date('YmdHis');
            $data['head'] = ['date'=> $time, 'status'=> 'success', 'code'=> 10, 'section'=> 'auth', 'action'=> 'signin'];
            $data['body'] = ['dom'=> 'signin', 'message'=> 'Per attivare il tuo account segui le istruzioni nell\'email che ti è stata inviata al tuo indirizzo ' .$obj->email];
            die(json_encode($data));
        }
        $stmt = null;
        $this->conn = null; // Chiude connessione PDO
    }

} // Chiude la classe Signin




/*****************************************VALidAZIONI*******************************************************************************/

/***************************************************************************************************|
 * VALidATE EMAIL BASE                                                                              |
 * fa una prima validificazione del 'email                                                          |
 * Controlla: che non sia vuota e che abbia caratteri validi                                        |
 * FILTER_SANITIZE_EMAIL                                                                            |
 * Rimuove tutti i caratteri eccetto le lettere, i numeri e i caratteri !#$%&'*+-/=?^_`{|}~@.[]     |
 * Non sono considerate valide le email con i caratteri '\<>                                        |
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

/********************************|
 * VALidATION PASSWORD           |
*********************************/
/*
private function validatePass($password) {
    $PASSWORD_LENGTH = 8;
    $password = trim($password);
    if (empty($password)) {
        $this->message = "Il campo password è vuoto.<br>";
    } else if (strlen($password) < $PASSWORD_LENGTH) {
        $this->message = "La password deve avere almeno " . $PASSWORD_LENGTH . " caratteri.<br>";
    } else {
        return $password;
    }
}
*/






