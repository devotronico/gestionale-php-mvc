<?php
namespace App\Models;

use App\Models\Email;
use \PDO;


class Password
{
    private $conn;
    private $message;
    private $email;
    private $hash; 
    private $password;

    public function __construct(PDO $conn, array $data = [])
    {

        $this->conn = $conn;


        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
          
                $this->email = isset($data['email'])? $this->isEmailStored($this->validateEmail($data['email'])): $this->message .= "Il parametro email è vuoto"; // route = auth/password/check

                $this->hash = isset($data['hash'])? $this->isHashStored($this->hashUrlValidate($data['hash'])): $this->message .= "Il parametro hash è vuoto";

                break;
            case 'POST':
         
                $this->email = isset($data['email'])? $this->isEmailStored($this->validateEmail($data['email'])): $this->message = "Il parametro email è vuoto"; // route = auth/password/check

                $this->password = isset($data['pass'])? $this->passSave($this->validatePass($data['pass']), $data['passconfirm'], $this->email): null; //  passSave($password, $password_conf, $email)

                break;
        }

    }




    public function getMessage()
    {
        return $this->message;
    }



/***********************************************************************************************|
 * SEND EMAIL                                                                                   |
 * Dopo aver inserito la mail nel campo input e premuto il bottone si attiverà questo metodo    |
 * Dopo la validazione dell' email e ottenuto l'hash corrispondete dal database                 |
 * il sistema ci invierà una mail per creare una nuova password                                 |
 * La mail conterrà un link con la rotta '/auth/password/new/'                                  |
 ***********************************************************************************************/
    public function sendEmail() {
 
        if ( !empty($this->email) && !empty($this->hash) ) {  // se email e password sono corretti 
          
            $Email = Email::newpass($this->email, $this->hash);
            $Email->send();
        }

    }







/*******************************************************************************************************|
 * EMAIL LINK                                                                                           |
 * Quando clicchiamo sul link di conferma presente nell'email verremo indirizzati di nuovo sul sito     |
 * Il link contiene le variabili/parametri $_GET['email'] e $_GET['hash']                               |
 * Dopo aver validato la email e la hash che sono stati passati dall'url col metodo GET                 |
 * Controlliamo se corrispondo ai valori presenti nella tabella 'users' del database                    |
 * Se sono uguali allora facciamo un controllo sul campo 'user_status'                                  |
 * Se il valore di 'user_status' è uguale a 0:                                                          |
 *  cambiamo il suo valore in 1. il valore 1 sta a indicare che la registrazione al sito è completa.    |
 * Se il valore di 'user_status' è uguale a 1:                                                          |
 *  lasciamo il suo valore in 1. vuol dire che questo account era già stato attivato precedentemente    |                                                    
 *******************************************************************************************************/
public function emailLink()
{
    if (!empty($this->message)) {exit;}
      
        $email = $this->email;  
        $hash = $this->hash; 

        $sql = "SELECT user_status FROM users WHERE user_email= :email AND user_activation_key= :hash";

        if ($stmt = $this->conn->prepare($sql)) 
        {
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
            $stmt->bindParam(':hash', $this->hash, PDO::PARAM_STR);
            if ($stmt->execute()) 
            {
                if ($stmt->rowCount() == 1) { 
                 
                    $user = $stmt->fetch(PDO::FETCH_ASSOC); 

                    if ( $user['user_status'] == 0 ) {

                        $sql = "UPDATE users SET user_status = 1 WHERE user_email = :email";
                        if ($stmt = $this->conn->prepare($sql)) 
                        {
                            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
            
                            $this->message .= $stmt->execute() ? '' : "Qualcosa è andato storto. Per favore prova più tardi.";

                        } else { $this->message .= "Qualcosa è andato storto. Per favore prova più tardi.";}
                    }
                    else {  $this->message .= 'questa account è già stato attivato';}
                } else { $this->message .= "Qualcosa è andato storto. Per favore prova più tardi.";} 
            } else { $this->message .= "Qualcosa è andato storto. Per favore prova più tardi.";}
        } else { $this->message .= "Qualcosa è andato storto. Per favore prova più tardi.";}
        $stmt = null;
        $this->conn = null; 
}




    /***********************************************************************************************************************|
     * PASS-SAVE    [set cookie]                                                                                            |
     * dopo aver validato la password e l' email ricevute con il metodo post, usiamo questi valori per ulteriori controlli  |
     * Prima controlliamo che la password sia uguale alla password di conferma                                              |
     * Poi controlliamo che l'email è presente nel database, se lo è, allora salviamo la nuova password                     |
     * E alla fine settiamo le variabile SESSION e il COOKIE come se avessimo eseguito il login                             |
     ***********************************************************************************************************************/
    private function passSave($password, $passwordconf, $email) {

        if ( $password )
        {
            if ($password === $passwordconf) 
            { 
                    $sql = "SELECT ID, role, user_name FROM users WHERE user_email = :email";
                    if ($stmt = $this->conn->prepare($sql)) 
                    { 
                        $stmt->bindParam(':email', $email, PDO::PARAM_STR, 32);
                        if ($stmt->execute()) 
                        {
                            if ($stmt->rowCount() == 1)
                            {
                                $user = [];
                                $user = $stmt->fetch(PDO::FETCH_ASSOC); //  PDO::FETCH_OBJ
                            
                                $password = password_hash($password, PASSWORD_DEFAULT); // Crea una password hash
                                $sql = "UPDATE users SET user_pass = :password WHERE user_email = '$email'"; 
                                if ($stmt = $this->conn->prepare($sql)) 
                                {
                                    $stmt->bindParam(':password', $password, PDO::PARAM_STR, 60);    
                                    if ($stmt->execute())  
                                    {
                                        $_SESSION['user_id'] = $user['ID'];
                                        $_SESSION['role'] = $user['role'];
                                        $_SESSION['user_name'] = $user['user_name'];
                                        setcookie("user_id", $user['ID'], time()+3600, '/');
                                    }
                                    else
                                    {
                                        $this->message .= "Qualcosa è andato storto. Per favore prova più tardi.";
                                    }
                                }
                            }
                            else
                            { 
                                $this->message .= "Un account con l' email <strong>$email</strong> non esiste";
                            }
                        } else {  $this->message .= "Qualcosa è andato storto. Per favore prova più tardi."; }   
                    } else {  $this->message .= "Qualcosa è andato storto. Per favore prova più tardi."; }   
        
            } else { $this->message .= "Le due password devono essere uguali"; } 
        } 
    }

/*****************************************VALIDAZIONI*******************************************************************************/



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
    private function validateEmail($email)
    {
        $email = trim($email);

        if ( empty($email) ) {
            $this->message .= "Il campo <strong>email</strong> è vuoto.<br>";
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

    /*******************************************************************************************************|
     * IS EMAIL STORED                                                                                      |
     * Controlla se l'email è già presente nel database                                                     |
     * Se lo è, allora la ritorna e viene prelevato anche il valore dell' hash corrispondete a questa email |
     *******************************************************************************************************/
    private function isEmailStored($email) 
    {
        if ( $email ) {

                $sql = "SELECT user_activation_key FROM users WHERE user_email = :email";

                if ($stmt = $this->conn->prepare($sql)) // Prepariamo lo Statement
                { 
                    $stmt->bindParam(':email', $email, PDO::PARAM_STR, 32);
                    if ($stmt->execute()) // Tentiamo di eseguire lo statement
                    {
                        if ($stmt->rowCount() == 1) {
                            $user = [];
                            $user = $stmt->fetch(PDO::FETCH_ASSOC);
                            // otteniamo l'hash dal database perchè può servirci nel caso l'utente non abbia ancora confermato l'account
                            $this->hash = $user['user_activation_key']; // [!]
                            $stmt = null; // Chiudi lo statement [!]
                            return $email; 

                        } else {
                            $this->message .= "L' email <strong>".$email."</strong> non è stata ancora registrata.<br>";
                        }

                    } else {
                        $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";
                    }
                } else {
                    $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";
                }
                $stmt = null; // Close statement
            } else {
                $this->message = "il campo email non può essere lasciato vuoto";
            }
        }




    /***************************************************************************************************|
     * HASH URL VALIDATE                                                                                |
     * Controlla se sono validi i caratteri che compongono l' hash che otteniamo dall' url [metodo GET] |                                  
     ***************************************************************************************************/
    private function hashUrlValidate($hash)
    {
        if (preg_match('/^[a-f0-9]{32}$/', $hash)) {
            return $hash;
        } else {
            $this->message .= "il parametro hash non è valido";
        }
    }


    /*******************************************************************************************************|
     * IS HASH STORED                                                                                       |
     * Controlla se l' hash è già presente nel database                                                     |
     * Se lo è, allora la ritorna                                                                           |
     *******************************************************************************************************/
    private function isHashStored($hash) 
    {
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
                $stmt = null; // Close statement
            } else {
                $this->message .= "il parametro hash è vuoto";
            }
        }


} // Chiude la classe Password
