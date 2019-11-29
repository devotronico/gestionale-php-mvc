<?php
namespace App\Models;

use PDO;
use Exception;
use Helpers\Sessions;

class Docs
{
    private $conn;
    // private $message;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }


    /**
     * LOGIN WITH COOKIE
     * Durante la navigazione delle pagine del gestionale
     * se nel browser è memorizzato il cookie con l' id dell' utente
     * allora in automatico si viene autenticati e
     * vengono assegnate le variabili di sessione, in questo modo
     * si può avere accesso a tutte le pagine protette dalla mancanza di credenziali di accesso
     * @return void
     */
    public function loginWithCookie() {
        $sql = 'SELECT id, role, name FROM users WHERE id = :id LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $_COOKIE['user_id'], PDO::PARAM_INT);
        if (!$stmt->execute()) { throw new Exception('Errore: mysqli::execute', -30); }
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        Sessions::setSession($user);
        // $_SESSION['user_id'] = $user['id'];
        // $_SESSION['role'] = $user['role'];
        // $_SESSION['user_name'] = $user['name'];
    }


    /**
     * GET TOTATL NUMBER OF DOCS
     * Ottiene il numero totale di tutti i documenti presenti nella tabella 'docs'
     * Questo metodo verrà richiamato solo per la rotta /docs per creare la paginazione
     * Lo scopo è quello di calcolare il numero di pagine necessarie per visualizzare tutti i documenti
     * es. se abbiamo 30 documenti e vogliamo che vengano visualizzati 3 documenti per ogni pagina
     * allora faremo 30 documenti / 3 che ci darà 10 pagine. in questo modo potremo fare la paginazione
     * @return void
     */
    public function getTotalNumberOfDocs() {
        $sql = 'SELECT COUNT(*) FROM fatture';
        if ($res = $this->conn->query($sql)) {
            $rows= $res->fetchColumn();
            return $rows;
        }
    }

    public function getListOfDocs($docStart, $docForPage) {
        $sql = "SELECT * FROM fatture ORDER BY id DESC LIMIT $docStart, $docForPage";
        $stm = $this->conn->query($sql);
        if ($stm) {
            $res = $stm->fetchAll(PDO::FETCH_OBJ);
            return $res;
        }
    }


/*******************************************************************************************************|
* PAGE POSTS                                                                                            |
* Facciamo una JOIN tra posts e users per ottenere tutti i posts con i dati dell' autore del post       |
* dalla tabella posts prendiamo [post_ID, title, datecreated, message]                                  |
* dalla tabella users prendiamo [user_email, user_name]                                                 |
* la relazione tra le tabelle posts e users è il campo posts.user_id e users.ID                         |
* in questo modo per ogni post abbiamo accesso ai dati dell'utente che ha scritto quel determinato post |
********************************************************************************************************/
public function pageDocs($postStart, $postForPage) {
    $sql = "SELECT * FROM posts INNER JOIN users ON posts.user_id = users.ID ORDER BY posts.datecreated DESC LIMIT $postStart, $postForPage";
    $stm = $this->conn->query($sql);
    if ($stm) {
        $res = $stm->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }
}

/*******************************************************************************************************|
* PAGE POSTS [modificare la descrizione]                                                                |
* Facciamo una JOIN tra posts e users per ottenere tutti i posts con i dati dell' autore del post       |
* dalla tabella posts prendiamo [post_ID, title, datecreated, message]                                  |
* dalla tabella users prendiamo [user_email, user_name]                                                 |
* la relazione tra le tabelle posts e users è il campo posts.user_id e users.ID                         |
* in questo modo per ogni post abbiamo accesso ai dati dell'utente che ha scritto quel determinato post |
********************************************************************************************************/
public function postsByDate($month, $year) {
    switch ($month) {
        case 'gennaio'  : $month = '01'; break;
        case 'febbraio' : $month = '02'; break;
        case 'marzo'    : $month = '03'; break;
        case 'aprile'   : $month = '04'; break;
        case 'maggio'   : $month = '05'; break;
        case 'giugno'   : $month = '06'; break;
        case 'luglio'   : $month = '07'; break;
        case 'agosto'   : $month = '08'; break;
        case 'settembre': $month = '09'; break;
        case 'ottobre'  : $month = '10'; break;
        case 'novembre' : $month = '11'; break;
        case 'dicembre' : $month = '12'; break;
    }

    $sql = "SELECT * FROM posts INNER JOIN users ON posts.user_id = users.ID WHERE MONTH(posts.datecreated) = $month AND YEAR(posts.datecreated) = $year ORDER BY posts.datecreated DESC";
    $stm = $this->conn->query($sql);
    if ($stm) {
        $res = $stm->fetchAll(PDO::FETCH_OBJ);
        return $res;
    }
}



/*******************************************************************************************************|
* GET DATES                                                                                             |
* questo metodo verrà richiamato solo per la pagina posts/blog per creare la paginazione                |
* Otteniamo il numero totale in assoluto di tutti i post presenti nella tabella 'posts'                 |
* Lo scopo è quello di calcolare il numero di pagine per i post                                         |
* es se abbiamo 30 post e vogliamo che vengano visualizzati 3 post ogni pagina                          |
* allora faremo 30post / 3 che ci darà 10 pagine. in questo modo potremo fare la paginazione            |
********************************************************************************************************/
public function getDates(){

    $sql = 'SELECT dateformatted FROM posts';
    if ($stm = $this->conn->query($sql)) {
        $dates = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $dates;
    }
}







} // chiude classe Blog

?>