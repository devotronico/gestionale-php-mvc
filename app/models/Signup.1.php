<?php
namespace App\Models;

use App\Models\Email;
use \PDO;


class Signup
{
    private $conn;
    private $name;
    private $email;
    private $password;
    private $type;
    private $message;

    public function __construct(PDO $conn, array $data = []) {

        $this->conn = $conn;

        $this->email = isset($data['email'])? $this->validateEmail($data['email']): null;

        $this->password = isset($data['password'])? $this->validatePass($data['password']): null;

        $this->name = isset($data['user_name'])? $data['user_name']: $this->validateUsername($data['email']);

        $this->type = $this->setUserType();
    }

    public function getMessage() {
        return $this->message;
    }


    /*******************************************************************************|
     * STORE DATA                                                                   |
     * Se la validazione dei valori email, password non ha generato messaggi errori |
     * procediamo con il salvataggio dei dati nel database                          |
    ********************************************************************************/
    public function storeData($image) {
        if (empty($this->message)) {

            $password= password_hash($this->password, PASSWORD_DEFAULT); // Creates a password hash
            $hash = md5(strval(rand(0, 1000)));
            $date = date('Y-m-d H:i:s');
            $status = 0;

            $sql = "INSERT INTO users (role, user_image, user_name, user_email, user_pass, user_registered, user_key, user_status) VALUES (?,?, ?, ?, ?, ?, ?, ?)";

            if ($stmt = $this->conn->prepare($sql)) {
                $stmt->bindParam(1, $this->type, PDO::PARAM_STR, 13);
                $stmt->bindParam(2, $image, PDO::PARAM_STR, 32);
                $stmt->bindParam(3, $this->name, PDO::PARAM_STR, 32);
                $stmt->bindParam(4, $this->email, PDO::PARAM_STR, 32);
                $stmt->bindParam(5, $password, PDO::PARAM_STR, 60);
                $stmt->bindParam(6, $date, PDO::PARAM_STR, 12);
                $stmt->bindParam(7, $hash, PDO::PARAM_STR, 32);
                $stmt->bindParam(8, $status, PDO::PARAM_INT);

                if ($stmt->execute()) {

                    $Email = Email::verify($this->email, $hash, $this->name);
                    $test = $Email->send();

                } else { $this->message = "Qualcosa è andato storto. Per favore prova più tardi."; }
            } else { $this->message = "Qualcosa è andato storto. Per favore prova più tardi."; }
            $stmt = null;
            $conn = null;
        }
    }




/***********************************************************************************************************************|
* SET USER TYPE                                                                                                         |
* al momento della registrazione viene definita anche il campo 'role' della tabella 'users'                        |
* il campo 'role' può assumere tre valori ['administrator' 'contributor' 'reader']                                 |
* Quando ci si registra in automatico il campo 'role' può essere settato solo come 'administrator' oppure 'reader' |
* Al primo utente che si registra in automatico il campo 'role' viene settato come 'administrator'                 |
* Mentre agli utenti che si registrano successivamente, in automatico il campo 'role' viene settato come 'reader'  |
* Solo l' utente che ha il campo 'role' settato come 'administrator' può  cambiare                                 |
* il campo 'role' degli altri utenti nei valori 'administrator', 'contributor', 'reader', banned                   |
************************************************************************************************************************/
private function setUserType() {

    $sql = 'SELECT COUNT(*) FROM users';
    if ($res = $this->conn->query($sql)) {
        $rows= $res->fetchColumn();
        if ( $rows === '0' ) {
            return 'administrator';
        } else {
            return 'reader';
        }
    }
}



/*****************************************VALIDAZIONI*******************************************************************************/

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
    private function validateEmail($email) {
        $email = trim($email);

        if ( empty($email) ) {
            $this->message .= "Il campo email è vuoto.<br>";
        }
        else
        {

            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            if ($email === false) {
                $this->message .= "<strong>".$email."</strong> non è un email valida.<br>";
            }
            else{
                return $email;
            }
        }
    }

    /********************************|
     * VALIDATION PASSWORD           |
    *********************************/
    private function validatePass($password)
    {
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


    /***********************************************************************************************|
     * VALIDATE USERNAME                                                                            |
     * al momento della registrazione non è obbligatorio fornire al form la 'username'              |
     * Quindi se il campo username viene lasciato vuoto il sistema crea in automatico la username   |
     * copiando dal valore dell' email che gli abbiamo fornito                                      |
     * la prima parte della stringa prima del simbolo '@'                                           |
     * es. da 'doe@email' il sistema crea l' username 'doe'                                         |
    ************************************************************************************************/
    private
     function validateUsername($email) {

        if ( empty($this->name) )
        {
            $name = explode('@', $this->email); // es. spezziamo l'email nel punto del simbolo '@'
            $this->name = $name[0];

        }
        return $this->name;

    }

} // Chiude la classe Signup
