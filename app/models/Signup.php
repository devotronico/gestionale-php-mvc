<?php

namespace App\Models;

use App\Models\Email;
use PDO;
use Exception;

class Signup
{
    private $conn;
    private $name;
    private $email;
    private $password;
    private $roletype;
    private $message;

    public function __construct(PDO $conn, object $obj) {
        $this->conn = $conn;
        $this->name = $obj->name;
        $this->email = $obj->email;
        $this->password = $obj->password;
        $this->roletype = $this->setUserType();
    }


    /**
     * IS EMAIL STORED
     * Controlla se l'email è già presente nel database.
     * Quando viene registra un nuovo account bisogna verificare
     * che l' email che l'utente inserisce nel form non sia già stata utilizza per registrarsi.
     * L'email deve avere un valore univoco, non ci possono essere duplicati nel database
     */
    private function isNewEmail() {
        $sql = 'SELECT COUNT(email) FROM users WHERE email = :email';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) { return false; }
        $stmt = null;
        return true;
    }


    /**
     * SET USER TYPE
     * al momento della registrazione viene definita anche il campo 'roletype' della tabella 'users'
     * il campo 'roletype' può assumere tre valori ['admin' 'contributor' 'reader']
     * Quando ci si registra in automatico il campo 'roletype' può essere settato solo come 'admin' oppure 'reader'
     * Al primo utente che si registra in automatico il campo 'roletype' viene settato come 'admin'
     * Mentre agli utenti che si registrano successivamente, in automatico il campo 'roletype' viene settato come 'reader'
     * Solo l' utente che ha il campo 'roletype' settato come 'admin' può  cambiare
     * il campo 'roletype' degli altri utenti nei valori 'admin', 'contributor', 'reader', banned
     * @return void
     */
    private function setUserType() {
        $sql = 'SELECT COUNT(*) FROM users';
        if ($res = $this->conn->query($sql)) {
            $rows= $res->fetchColumn();
            if ( $rows === '0' ) {
                return 'admin';
            } else {
                return 'ordinary';
            }
        }
    }


    /**
     * type:
     * type: VARCHAR,  length: 32, es.: utente.
     * name =>
     * type: VARCHAR,  length: 32, es.: Rossi.
     * email =>
     * type: VARCHAR,  length: 32, es.: user@mail.it.
     * password =>
     * type: VARCHAR, length: 255, es.: $2y$10$KimdfbZihiepECDtVLZPBu9.VFgj.Y.GQAceGLPvn89ZiFnQgg4ji
     * descrizione: archiviare in una colonna del db in grado di espandersi oltre i 60 caratteri,
     * 255 caratteri sarebbe una buona scelta.
     * hash =>
     * type: VARCHAR,  length: 32, format: [a-z0-9]{32} )
     * verified =>
     * type: TINYINT,  length: 1 )
     * created_at =>
     * type: DATETIME, length: 19, format: yyyy-mm-dd 00:00:00
     * updated_at =>
     * type: DATETIME, length: 19, format: yyyy-mm-dd 00:00:00
     */
    public function signup() {
        if (!$this->isNewEmail()) { throw new Exception('Un account con L\' email <b>' . $this->email . '</b> è stato già registrato.', -10);}
        $password = password_hash($this->password, PASSWORD_DEFAULT);
        $hash = md5(strval(rand(0, 1000)));
        $verified = 0;
        $date = date('Y-m-d H:i:s');

        $sql = 'INSERT INTO users (roletype, name, email, password, hash_email, verified, created_at, updated_at) VALUES (:roletype, :name, :email, :password, :hash_email, :verified, :created_at, :updated_at)';

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':roletype', $this->roletype, PDO::PARAM_STR, 32);
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR, 32);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR, 255);
        $stmt->bindParam(':hash_email', $hash, PDO::PARAM_STR, 32);
        $stmt->bindParam(':verified', $verified, PDO::PARAM_INT);
        $stmt->bindParam(':created_at', $date, PDO::PARAM_STR, 19);
        $stmt->bindParam(':updated_at', $date, PDO::PARAM_STR, 19);

        if (!$stmt->execute()) { throw new Exception('Errore: mysqli::execute', -30); }

        $stmt = null; // doing this is mandatory for connection to get closed

        return ['type' => $this->roletype, 'name' => $this->name, 'email' => $this->email, 'password' => $password, 'hashEmail' => $hash, 'verified' => $verified,'created_at' => $date, 'updated_at' => $date];
    }


} // Chiude la classe Signup
