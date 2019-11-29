<?php
namespace App\Controllers;

use PDO;


class HomeController extends Controller
{

    protected $conn;

    public function __construct(PDO $conn){
         // ereditiamo il costruttore della classe madre (Controller) per ottenere il valore di $this->device che può essere 'desktop' oppure 'mobile'
        parent::__construct();
        $this->conn = $conn; // otteniamo la connessione con la quale possiamo fare le query al database
        $this->page = 'home';
    }


/**
 * Route: '', '/'
 * Method: GET
 * Pagina Principale
 * @return void
 */
public function home() {
    $template = ['navbar', $this->page];
    $logo = 'logo';
    $navlink = $this->page;
    $this->content = view($this->device, $this->page, $template, compact('navlink', 'logo'));
}





/***********************************************|
* HOME  metodo = GET    route = home            |
************************************************/
// public function home(){
//     $photo = $this->device.'.photo';
//     $files=[
//         'navbar',
//         'cover',
//         'portfolio',
//         'project',
//         'skills',
//         'contact',
//         'about',
//         'footer'
//         ];
//     $this->content = view($this->device,'home', $files, compact('photo'));
// }


// public function contact() {
//     $Email = Email::toMe($_POST);
//     $Email->send();

//     $message = "Grazie per averci contattato, risponderemo il prima possibile";
//     $photo = $this->device.'.photo';

//     $files=[
//         'navbar',
//         'message',
//         'cover',
//         'portfolio',
//         'project',
//         'skills',
//         'contact',
//         'about',
//         'footer'
//         ];

//     $this->content = view($this->device, 'home', $files, compact('photo', 'message'));
// }


/***********************************************************|
* DOWNLOAD      metodo = GET    route = home/id/download    |
************************************************************/
// public function download() {
//     $dir = 'public/download/';

//     $filename = 'NinjaBit.zip'; //

//     // controlliamo che ci siano caratteri validi nel nome del file
//     if (!preg_match('/^[a-zA-Z0-9]+\.[a-z]{2,3}$/i',$filename)) {
//         $filename = false; die('errore');
//       }else{
//        $file = $dir . $filename;
//       }

//     if (!file_exists($file))
//     {

//       echo "Il file NON esiste!";
//     }else{
//       //  echo "Il file esiste!";
//     header('Content-Description: File Transfer');
//     header('Content-Type: application/octet-stream');
//     header('Content-Disposition: attachment; filename="'.basename($file).'"');
//     header('Expires: 0');
//     header('Cache-Control: must-revalidate');
//     header('Pragma: public');
//     header('Content-Length: ' . filesize($file));
//     readfile($file);
//     exit;
//     }
// }








} // chiude classe HomeController

