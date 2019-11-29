<?php
namespace App\Models;
use \PDO;


class Post
{
    private $conn;
    private $message;

    public function __construct(PDO $conn){
        
        $this->conn = $conn;
    }
    

    public function getMessage()
    {
        return $this->message;
    }


    /***************************************************************************************|
     * LOGIN WITH COOKIE                                                                    |
     * Quando dalla home passiamo alla pagina del blog                                      |
     * se abbiamo il COOKIE allora viene fatto un login automatico.                         |
     * ci andiamo a prendere dalla tabella 'users' solo il valore del campo 'role'     |            
    ****************************************************************************************/
    public function loginWithCookie() {       

        $sql = 'SELECT ID, role, user_name FROM users WHERE ID = :id LIMIT 1';
        
        if ($stmt = $this->conn->prepare($sql)) 
        {
            $stmt->bindParam(':id', $_COOKIE['user_id'], PDO::PARAM_INT);
            if ($stmt->execute()) 
            {
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['user_id'] = $user['ID']; 
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['user_name'] = $user['user_name'];
            }
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
public function pagePosts($postStart, $postForPage){
  
    $sql = "SELECT * FROM posts INNER JOIN users ON posts.user_id = users.ID ORDER BY posts.datecreated DESC LIMIT $postStart, $postForPage";

    $stm = $this->conn->query($sql);
    if ( $stm ){

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
public function postsByDate($month, $year){
  

switch ( $month ) {

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

 //   $sql = "SELECT * FROM posts INNER JOIN users ON posts.user_id = users.ID WHERE DATENAME(month, $month) AS DatePartString; ORDER BY posts.datecreated DESC";

   
    $stm = $this->conn->query($sql);
    if ( $stm ){

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



/*******************************************************************************************************|
* TOTAL POSTS                                                                                           |
* questo metodo verrà richiamato solo per la pagina posts/blog per creare la paginazione                |
* Otteniamo il numero totale in assoluto di tutti i post presenti nella tabella 'posts'                 |
* Lo scopo è quello di calcolare il numero di pagine per i post                                         |
* es se abbiamo 30 post e vogliamo che vengano visualizzati 3 post ogni pagina                          |
* allora faremo 30post / 3 che ci darà 10 pagine. in questo modo potremo fare la paginazione            |
********************************************************************************************************/
public function totalPosts(){
    
    $sql = 'SELECT COUNT(*) FROM posts';
    if ($res = $this->conn->query($sql)) {
        $rows= $res->fetchColumn();
        return $rows;
    }
}


//============== POST ============================================================================================================================================

    /***************************************************************************************|
    * FIND                                                                                  |
    ****************************************************************************************/
    public function find($postid){
            
       
        $sql = 'UPDATE posts SET views = views + 1 WHERE post_ID = :postid';
        $stm = $this->conn->prepare($sql);
        $stm->execute(['postid'=>$postid]); 

        $sql = 'SELECT * FROM posts
        LEFT JOIN users ON users.ID = posts.user_id
        WHERE posts.post_ID = :postid
        ORDER BY posts.datecreated DESC';

        $stm = $this->conn->prepare($sql); 

        $stm->execute(['postid'=>$postid]); 

        if ( $stm ){

            $data = $stm->fetch(PDO::FETCH_OBJ);
            return $data;
        }
     }

    
//*************************************************EDIT************************************************************************************ 


/***************************************************************************************|
* EDIT                                                                                  |
****************************************************************************************/
public function edit($postid){
        
    $sql = 'SELECT * FROM posts WHERE post_ID = :postid LIMIT 1';
    $stm = $this->conn->prepare($sql); 
    $stm->bindParam(':postid', $postid, PDO::PARAM_INT);
    $stm->execute(); 
    if ( $stm ) {
        $result = $stm->fetch(PDO::FETCH_OBJ);
        return $result;
    }
 }



    /*******************************************************************************************************************|
    * DELETE IMAGE                                                                                                      |
    * quando vogliamo cambiare l'immagine di un post                                                                    |
    * dobbiamo prima eliminare il file immagine attuale che sta nella cartella dove è immagazzinato,                    |
    * Ci occorre il nome del'immagine il quale lo otteniamo facendo una select al database con l'id del post            |                 
    * Utilizziamo con la funzione builtin di php 'unlink' passandoci il percorso del file più il nome del file          |
    * l'immagine viene eliminata                                                                                        |
    ********************************************************************************************************************/
    public function deletePostImage($id) {
    
        $id = (int)$id;
        $sql = "SELECT image FROM posts WHERE post_ID = :id";

        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) { 

            $res = $stmt->fetch(PDO::FETCH_OBJ);

            if ( $res->image != '' ) {
                if ( unlink("public/img/posts/$res->image") ) {

                //  L' immagine è stata eliminata.
                } else {
                    //$this->message = "L' immagine non è stata eliminata.";
                }
            }
        } else {
            $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";
        }
        $stmt = null; 
    }



    /*******************************************************************************************************************|
    * CHECK IMAGE EXISTS                                                                                                |
    * Se durante lo sviluppo decidiamo di cancellare delle immagini dei post a mano                                     |
    * questo metodo in automatico si occupa di cancellare anche il nome del file che è memorizzato nel database         |
    ********************************************************************************************************************/
    public function checkImageExists($id) {
    
        $id = (int)$id;
        $sql = "SELECT image FROM posts WHERE post_ID = :id";

        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) { 

            $res = $stmt->fetch(PDO::FETCH_OBJ);

            if ( $res->image != '' ) {

                $filename = 'public/img/posts/'.$res->image;

                if (!file_exists($filename)) {
               
                    $sql = "UPDATE posts SET image = null WHERE post_ID = :id";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                }
            }
        } else {
            $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";
        }
        $stmt = null; 
    }
       
    


/***************************************************************************************|
* UPDATE                                                                                |
* Modifica un post creato in precedenza                                                 |
****************************************************************************************/
public function update(int $postid, array $data=[], $image=''){
        
    $messtruncate = truncate_words($data['text'], 10); 
                                               
    $sql = "UPDATE posts SET title = :title, image = COALESCE(NULLIF(:image, ''),image), message = :message, messtruncate = :messtruncate WHERE post_ID = :id";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':title', $data['title'], PDO::PARAM_STR, 255);
    $stmt->bindParam(':image', $image, PDO::PARAM_STR, 32);
    $stmt->bindParam(':message', $data['text'], PDO::PARAM_STR);
    $stmt->bindParam(':messtruncate', $messtruncate, PDO::PARAM_STR, 255);
    $stmt->bindParam(':id', $postid, PDO::PARAM_INT);
    $stmt->execute();
    $conn = null;
    return $stmt->rowCount();
 }

//************************************************************************************************************************************* 

/***************************************************************************************|
* SAVE                                                                                  |
* Salviamo nel database 
****************************************************************************************/
public function save(array $data=[], string $image=''){

$messtruncate = truncate_words($data['text'], 10); 
$datecreated = date('Y-m-d H:i:s');
$dateformatted = dateFormatted($datecreated);
$sql = 'INSERT INTO posts (user_id, title, image, message, messtruncate, datecreated, dateformatted) VALUES (:user_id, :title, :image, :message, :messtruncate, :datecreated, :dateformatted)';
$stm = $this->conn->prepare($sql); 
$stm->execute([ 
    'user_id'=> $_SESSION['user_id'],
    'title'=> $data['title'], 
    'image'=> $image, 
    'message'=>$data['text'], 
    'messtruncate'=>$messtruncate, 
    'datecreated'=>$datecreated,
    'dateformatted'=>$dateformatted,
]); 
$conn = null;
return $stm->rowCount();
}




/*******************************************************************************************************************|
* COUNT-POSTS                                                                                                       |
* questo metodo incrementa o decrementa il numero dei post del campo 'user_num_posts' della tabella users           |                          
* a seconda se il secondo argomento passato sia 1 oppure -1                                                         |
* Avendo l'id 'users', per prima cosa faccimo una SELECT per ottenere il valore/numero del campo 'user_num_posts'   |
* quindi modifichiamo il valore del campo 'user_num_posts' e lo aggiorniamo/salviamo nel database con 'UPDATE'      |
********************************************************************************************************************/
public function countPosts(int $sign){
        
    $sql = "SELECT user_num_posts FROM users WHERE ID = :id";
    $stm = $this->conn->prepare($sql); 
    $stm->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stm->execute();
    if ( $stm ){
        if ($res = $stm->fetch(PDO::FETCH_OBJ)) {
            $num = (int)$res->user_num_posts;
            $num+= $sign;
            $sql = 'UPDATE users SET user_num_posts = :user_num_posts WHERE ID = :id';
            $stm = $this->conn->prepare($sql); 
            $stm->execute([ 
                'id'=>$_SESSION['user_id'],
                'user_num_posts'=> $num,   
            ]); 
        }
    }
 }  

/***************************************************************************************|
* DELETE-ONE                                                                            |
* cancelliamo un post                                                                   |
****************************************************************************************/
     public function deletePost(int $postid){
        
        $sql = 'DELETE FROM posts WHERE post_ID = :id';
        $stm = $this->conn->prepare($sql); 
        $stm->bindParam(':id', $postid, PDO::PARAM_INT); 
        $stm->execute(); 
     }
 








}

?>