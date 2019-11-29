<?php
namespace App\Models;
use \PDO;



class Comment
{
    protected $conn;

    public function __construct(PDO $conn){
        
        $this->conn = $conn;
    }


/*******************************************************************************************************************************************************************|
* ALL                                                                                                                                                               |
* La colonna 'post_id' della tabella 'comments' è uguale/collegato alla colonna 'id' della tabella posts                                                       |
* Quindi per ottenere tutti i commenti relativi a un singolo post dobbiamo passare come argomento a questo metodo l' id del post che                                |
* ricaviamo dal url.                                                                                                                                                |
* Oltre ai commenti ci occorrono anche i dati della tabella 'users'(user_image, user_name, user_email) per avere le info sull' autore che ha scritto il commento.   |
* La colonna 'user_id' di 'comments' è collegata alla colonna ID di users                                                                                      |
* Quindi per ottenere contemporaneamente i dati dalle tabelle 'comments' e 'users' facciamo una 'Inner Join'                                                   |
********************************************************************************************************************************************************************/    
    public function all($postid){
        $postid = (int)$postid;
        $sql = 'SELECT * FROM comments INNER JOIN users WHERE comments.user_id = users.ID AND comments.post_id = :postid ORDER BY c_datecreated DESC';
        $stm = $this->conn->prepare($sql);
        $stm->bindParam(':postid', $postid, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll();
    }

    public function total(int $postid){
        $sql = 'SELECT * FROM comments WHERE post_id = postid';
        $stm = $this->conn->prepare($sql);
        $stm->bindParam(':postid', $postid, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll();
    }


/***************************************************************************************************************************|
* SAVE   url = /post/:id/comment                                                                                            |
* Salviamo un commento nella tabella 'comments'                                                                        |
* il valore della colonna 'post_id' lo prendiamo dal URL ':id',                                                             |
* 'post_id' ci serve per relazionare questo commento a un determinato post cioè il post in cui l'utente va a commentare.    |
* 'user_id' ci serve per relazionare questo commento a un determinato uente cioè all'autore che ha scritto questo commento. |
* 'c_datecreated' è la data di creazione del commento e la otteniamo con la funzione date.                                    |
****************************************************************************************************************************/ 
public function save(array $data=[]){
    
    $c_datecreated = date('Y-m-d H:i:s');
    $c_dateformatted = dateFormatted($c_datecreated);
    $sql = 'INSERT INTO comments (post_id, user_id, comment, c_datecreated, c_dateformatted) VALUES (:post_id, :user_id, :comment, :c_datecreated, :c_dateformatted)';
    $stm = $this->conn->prepare($sql); 
    $stm->execute([ 
        'post_id'=> $data['post_id'], 
        'user_id'=> $_SESSION['user_id'], 
        'comment'=>$data['comment'], 
        'c_datecreated'=>$c_datecreated,
        'c_dateformatted'=>$c_dateformatted,
        ]); 
    
    return $stm->rowCount();
    }

/*******************************************************************************************************************|
* SAVE   url = "/post/:id/delete"                                                                                   |
* Se l'utente è l'amministratore può cancellare un post,                                                            |
* e di conseguenza verranno cancellati anche tutti i commenti relativi al post cancellato.                          |
* questo viene fatto ottenendo dall URL :id che consente una relazione tra le tabelle posts e comments tramite |
* i loro rispettivi campi/colonne 'id'(posts) e 'post_id'(comments)                                            |
********************************************************************************************************************/ 
    public function deleteAll(int $postid){

       $sql = 'DELETE FROM comments WHERE post_id = :id';
       $stm = $this->conn->prepare($sql); 
       $stm->bindParam(':id', $postid, PDO::PARAM_INT); 
       $stm->execute(); 
    }


/***************************************************************************************************************************|
* SAVE   url = '/comment/:id/delete'                                                                                        |
* Se l'utente è l'amministratore può cancellare qualsiasi commento, uno alla volta, tramite l'id univoco del commento       |
* che otteniamo dal URL                                                                                                     |
****************************************************************************************************************************/ 
    public function deleteOne(int $commentid){

        $sql = 'DELETE FROM comments WHERE comment_ID = :id'; 
        $stm = $this->conn->prepare($sql); 
        $stm->bindParam(':id', $commentid, PDO::PARAM_INT); 
        $stm->execute(); 
     }


/***********************************************************************************************************************************|
* GET POST ID                                                                                                                       |
* Con l'id della tabella comments ci andiamo a prendere il valore del campo post_id che è relativo all'id della tabella posts       |
* In questo modo possiamo associare il commento al suo post                                                                                                  
************************************************************************************************************************************/ 
    public function getId(string $column, int $commentid){

        $sql = "SELECT $column FROM comments WHERE comment_ID = :id";
        $stm = $this->conn->prepare($sql);
        $stm->bindParam(':id', $commentid, PDO::PARAM_INT);
        $stm->execute();
        $res= $stm->fetch(PDO::FETCH_ASSOC);
        $id = (int)$res[$column];
        return $id;
    }





/***********************************************************************************************************************|
* USER NUM COMMENTS                                                                                                     |
* questo metodo incrementa o decrementa il numero dei commenti del campo 'user_num_comments' della tabella users        |                          
* a seconda se il secondo argomento passato sia 1 oppure -1                                                             |
* Avendo l'id 'users', per prima cosa faccimo una SELECT per ottenere il valore/numero del campo 'user_num_comments'    |
* quindi modifichiamo il valore del campo 'user_num_comments' e lo aggiorniamo/salviamo nel database                    |
************************************************************************************************************************/

public function userNumComments(int $sign, $id=null){
    $id = isset($id) ? $id : $_SESSION['user_id'];   
    $sql = "SELECT user_num_comments FROM users WHERE ID = :id";
    $stm = $this->conn->prepare($sql); 

    $stm->bindParam(':id', $id, PDO::PARAM_INT);
    $stm->execute();

    if ( $stm ){
        if ($res = $stm->fetch(PDO::FETCH_OBJ)) {
            $num = (int)$res->user_num_comments;
            $num+= $sign;
            $sql = 'UPDATE users SET user_num_comments = :user_num_comments WHERE ID = :id';
            $stm = $this->conn->prepare($sql); 
            $stm->bindParam(':user_num_comments', $num, PDO::PARAM_INT);
           // $stm->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->execute();
        }
    }
} 



/*******************************************************************************************************************|
* POST NUM COMMENTS                                                                                                 |
* questo metodo incrementa o decrementa il numero dei commenti del campo 'num_comments' della tabella 'posts'       |                            
* a seconda se il secondo argomento passato sia 1 oppure -1                                                         |
* Avendo l'id di un post, per prima cosa faccimo una SELECT per ottenere il valore/numero del campo 'num_comments'  |
* quindi modifichiamo il valore del campo 'num_comments' e lo aggiorniamo/salviamo nel database con 'UPDATE'        |
********************************************************************************************************************/

public function postNumComments(int $sign, int $id){
        
    $sql = 'SELECT num_comments FROM posts WHERE post_ID = :id';
    $stm = $this->conn->prepare($sql); 
    $stm->execute(['id'=>$id]); 

    if ( $stm ){
        $res = $stm->fetch(PDO::FETCH_OBJ);
        $num = (int)$res->num_comments;
        $num+= $sign;
    
        $sql = 'UPDATE posts SET num_comments = :num_comments WHERE post_ID = :id';
        $stm = $this->conn->prepare($sql); 
        $stm->execute([ 
            'id'=>$id,
            'num_comments'=> $num,   
        ]); 
    }
 }     





    }




