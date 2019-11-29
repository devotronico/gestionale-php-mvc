<?php
namespace App\Controllers;

use PDO;
use App\Models\User;
// use App\Models\Image;


class UserController extends Controller
{
    protected $bytes = 500000;
    public function __construct(PDO $conn){
        parent::__construct();
        $this->conn = $conn;
    }


    /**
     * Route: user/:id
     * Method: GET
     * Se l'utente si è loggato puo` accedere alla sua pagina del profilo
     * [a] questo controllo serve per evitare che l'utente modificando l'id dall'url
     * possa accedere al profilo di altri utenti
     * getUserId() restituisce l'id della variabile $_SESSION['id'] la quale e` stata valorizzata
     * nella fase di login/signin dell'utente ottenendola dal database
     *
     * @param [type] $id - ottenuto presente nel link della navbar
     * @return void
     */
    public function user($id) {
        $this->page = 'user';
        $User = new User($this->conn);
        $data = $User->getData($id);

        if (getUserId() === $data->id) { // [a]

            $navlink = $this->page;
            // $acceptFileType = '.jpg, .jpeg, .png';
            // $bytes = $this->bytes;
            // $megabytes = $bytes * 0.000001;
            $templates = ['navbar', $this->page];
            $this->content = view($this->device, $this->page, $templates, compact('navlink', 'data'));
            // $this->content = view($this->device, 'auth', $templates, compact('navlink', 'data', 'bytes', 'megabytes', 'acceptFileType'));
        } else {
            $message = 'Utente non trovato';
            redirect('/', $message);
        }
    }
      /***************************************************************************************************************************************|
    * PROFILE       metodo = POST   route = auth/id/profile                                                                                 |
    * Se si clicca sul navlink nome di un utente si viene indirizzati alla pagina di profilo dell'utente dove vengono visualizzati alcune info |
    * Prese dalle tabelle 'users' 'posts' 'comments' relative a quel utente                                                                 |
    * Se l'utente ha il campo 'role' come 'administrator' allora può cambiare l'role degli altri utenti dalla pagina del profilo  |
    ****************************************************************************************************************************************/
    // public function user($id) {
    //     $this->page = 'user';
    //     $User = new User($this->conn);
    //     $data = $User->profile($id);

    //     if ( isset($_SESSION['user_id']) &&  $data->ID === $_SESSION['user_id'] ) {

    //         $navlink="profile";
    //         $acceptFileType=".jpg, .jpeg, .png";
    //         $bytes = $this->bytes;
    //         $megabytes = $bytes * 0.000001;
    //         $files=[$this->device.'.navbar-auth', 'profile.user'];
    //         $this->content = view($this->device, 'auth', $files, compact( 'data', 'navlink', 'bytes', 'megabytes', 'acceptFileType'));
    //     }
    //     else
    //     {
    //         $files=[$this->device.'.navbar-auth', 'profile'];
    //         $this->content = view($this->device, 'auth', $files, compact( 'data', 'navlink' ));
    //     }
    // }



    /***************************************************************************************************************|
    * SET USER TYPE     metodo = GET    route = profile/id/setUsertype                                               |
    ****************************************************************************************************************/
    public function setUsertype($id, $usertype) {
        $User = new User($this->conn);
        $User->modUserType($id, $usertype);
        $this->profile($id);
    }
    /***************************************************************************************************************|
    * SET ADMINISTRATOR     metodo = GET    route = auth/id/administrator                                           |
    ****************************************************************************************************************/
    // public function setAdministrator($id) {
    //     $User = new User($this->conn);
    //     $User->modUserType($id, 'administrator');
    //     $this->profile($id);
    // }
    /***************************************************************************************************************|
    * SET CONTRIBUTOR       metodo = GET    route = auth/id/contributor                                             |
    ****************************************************************************************************************/
    // public function setContributor($id) {
    //     $User = new User($this->conn);
    //     $User->modUserType($id, 'contributor');
    //     $this->profile($id);
    // }
    /***************************************************************************************************************|
    * SET READER     metodo = GET   route = auth/id/reader                                                          |
    ****************************************************************************************************************/
    // public function setReader($id) {
    //     $User = new User($this->conn);
    //     $User->modUserType($id, 'reader');
    //     $this->profile($id);
    // }
    /***************************************************************************************************************|
    * SET BANNED     metodo = GET   route = auth/id/banned                                                          |
    ****************************************************************************************************************/
    // public function setBanned($id) {
    //     $User = new User($this->conn);
    //     $User->modUserType($id, 'banned');
    //     $this->profile($id);
    // }

    /***************************************************************************************************************|
    * SET AVATAR     metodo = POST   route = auth/:id/image                                                         |
    ****************************************************************************************************************/
    public function setAvatar($id){

        $User = new User($this->conn);
        $User->deleteAvatar($id); // cancelliamo l'immagine

        $Image = new Image('fixed', 92, 92, $this->bytes, 'auth', $_FILES); // creiamo una nuova immagine

        $imageName = !is_null($Image->getNewImageName()) ? $Image->getNewImageName() : 'default.jpg'; // otteniamo il nuovo nome dell'immagine

        $User->storeAvatar($id, $imageName); // salviamo il nuovo nome dell'immagine nel database


        if (  empty( $User->getMessage()) && empty( $Image->getMessage()) ) {

            $this->profile($id);
        } else {

            $message = 'Si è verificato un errore<br>';
            $message .= $User->getMessage();
            $message .= $Image->getMessage();

            $uri ='/auth/'.$_SESSION['user_id'].'/profile';

            redirect($uri, $message);
        }
    }



} // chiude classe ProfileController
