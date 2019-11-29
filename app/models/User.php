<?php
namespace App\Models;

use PDO;


class User
{

    private $conn;
    private $message;



    public function __construct(PDO $conn)
    {

        $this->conn = $conn;
    }

    public function getMessage()
    {
        return $this->message;
    }


    /*******************************************************************************************|
     * PROFILE                                                                                  |
     * Otteniamo tutti i dati dalle tabelle 'users' 'posts' 'comments' di uno specifico utente  |
    ********************************************************************************************/
    public function getData($id) {
        $id = (int)$id;
        $sql = 'SELECT * FROM users WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt) {
            $data = $stmt->fetch(PDO::FETCH_OBJ);
            //echo '<pre>', print_r($data) ,'</pre>';
            return $data;
        }
    }
    // public function getData($id) {

    //     $id = (int)$id;
    //     $sql = 'SELECT * FROM users
    //     LEFT JOIN posts ON users.ID = posts.user_id
    //     LEFT JOIN comments ON users.ID = comments.user_id
    //     WHERE users.ID = :id
    //     ORDER BY posts.datecreated DESC, comments.c_datecreated DESC';

    //     if ($stmt = $this->conn->prepare($sql))
    //     {
    //         $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    //         if ($stmt->execute())
    //         {
    //             if ( $stmt ){

    //                 $data = $stmt->fetch(PDO::FETCH_OBJ);
    //                 //echo '<pre>', print_r($data) ,'</pre>';
    //                 return $data;
    //             }
    //         }
    //     }
    // }



    /*******************************************************************************************************************|
    * DELETE AVATAR                                                                                                     |
    * quando cambiamo immagine del avatar dalla nostra pagina del profilo                                               |
    * dobbiamo prima eliminare il file immagine da sostituire che sta nella cartella dove è immagazzinato,              |
    * per fare questo utilizziamo il nostro id per ottenere il nome dell' immagine dal database                         |
    * se il nome dell'immagine è diverso dall'immagine di default che non vogliamo cancellare perchè la riutilizzeremo, |
    * utilizziamo con la funzione builtin di php 'unlink' passandoci il percorso del file più il nome del file          |
    * l'immagine viene eliminata                                                                                        |
    ********************************************************************************************************************/
    public function deleteAvatar($id) {

        $id = (int)$id;
        $sql = "SELECT user_image FROM users WHERE ID = :id";

        if ($stmt = $this->conn->prepare($sql)) {

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {

                $res = $stmt->fetch(PDO::FETCH_OBJ);

                if ( $res->user_image != 'default.jpg' ) {
                    if ( unlink("public/img/auth/$res->user_image") ) {

                    //  L' immagine è stata eliminata.
                    } else {
                        $this->message = "L' immagine non è stata eliminata.";
                    }
                }
            } else {
                $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";
            }
        } else {
            $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";
        }
        $stmt = null; // Close statement
    }



    /*******************************************************************************************|
    * STORE AVATAR                                                                              |
    ********************************************************************************************/
    public function storeAvatar($id, $image) {

        $id = (int)$id;
        $sql = "UPDATE users SET user_image = :user_image  WHERE ID = :id";

        if ($stmt = $this->conn->prepare($sql)) {

            $stmt->bindParam(':user_image', $image, PDO::PARAM_STR, 32);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {

               // $this->message = "Tutto OK.";
            } else {
                $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";
            }
        } else {
            $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";
        }
        $stmt = null; // Close statement
    }






    /***************************************************************************************************************|
    * MOD USER TYPE                                                                                                 |
    ****************************************************************************************************************/
    public function modUserType($id, $type) {

        $id = (int)$id;
        $sql = 'UPDATE users SET role = :role WHERE users.ID = :id LIMIT 1';

        if ($stmt = $this->conn->prepare($sql))
        {
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':role', $type, PDO::PARAM_STR, 13);
            $stmt->execute();
        }
    }

    /***************************************************************************************************************|
    * MOD USER TYPE    [!]                                                                                          |
    ****************************************************************************************************************/
    // public function modUserType($id, $type) {

    //     $id = (int)$id;
    //     $sql = 'UPDATE users SET role = :role WHERE users.ID = :id LIMIT 1';

    //     if ($stmt = $this->conn->prepare($sql))
    //     {
    //         $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    //         $stmt->bindParam(':role', $type, PDO::PARAM_STR, 13);
    //         $stmt->execute();
    //     }
    // }


} // Chiude la classe User
