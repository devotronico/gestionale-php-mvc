<?php

namespace App\Controllers;

use App\Models\Docs;
use PDO;

class DocsController extends Controller
{
    protected $Docs ;

    public function __construct(PDO $conn) {
        // if (!isset($_SESSION['authenticated'])) {
        //     redirect('/');
        // }
        parent::__construct();
        $this->conn = $conn; // otteniamo la connessione con la quale possiamo fare le query al database
        $this->Docs = new Docs($conn);  // creiamo qui un istanza della classe 'Blog' e gli passiamo la connessione al database
    }


/**
 * GET DOCS
 * metodo = GET
 * route = /doc
 * Ottiene tutti i documenti di una pagina
 * Se ci sono i post allora viene caricato anche il template della paginazione
 *
 * Spiegazione Paginazione
 * 'page' è il numero della pagina in cui ci si trova.
 * 'docForPage' è il numero di documenti che ci sono per ogni pagina.
 * 'docStart' è uguale al numero precedente del primo post della pagina in cui ci si trova
 * Se ci troviamo nella pagina 3 {'currentPage'=3} e
 * abbiamo deciso che ogni pagina deve avere 2 documenti{'docForPage'=2}
 * allora il primo documento della terza pagina deve essere il documento numero 4{'docStart'=4}
 * 1  2  3 pagine {'currentPage'}
 * 12 34 56 il numero dei post che visualizza se abbiamo impostato {'postForPage'=2}
 * 0  2  4 sono i valori che ci servono per cominciare a contare i post da visualizzare {'postStart'} 
 * @param integer $currentPage
 * @return void
 */
public function getDocs($currentPage=1) {
    if (isset($_COOKIE['user_id'])) {
         $this->Docs->loginWithCookie();
    }

    // $totalDocs = $this->Docs->getTotalNumberOfDocs();
    $navlink = 'doc-list';
    $totalDocs = ''; // DEBUG
    if (empty($totalDocs)) {
        $this->page = 'doc.empty';
        $templates = ['navbar', $this->page];
        $this->content = view($this->device, 'doc', $templates, compact('navlink'));
        // $this->content = view($this->device, 'doc', $files, compact('navlink', 'page'));
     } else {
        $this->page = 'doc.list';
        $docForPage = $this->device === 'desktop'? 5 : 3;
        for ($i=0, $docStart=-$docForPage; $i<$currentPage; $docStart+=$docForPage, $i++);
        $docs = $this->Docs->getListOfDocs($docStart, $docForPage);
        $templates = ['navbar', $this->page];
        $this->content = view($this->device, 'doc', $templates, compact('navlink', 'docs', 'dates', 'currentPage', 'totalDocs', 'docForPage'));
     }
}


public function createDoc() {
    $this->content = 'crea un documento';
}

//getPostsByDate
/***************************************************************************************|
* GET POST BY DATE      metodo = GET    path = post/id                                  |
* questa classe mostrerà un solo post e mostrerà tutti i commenti legati a questo post  |
****************************************************************************************/
/*
public function getPostsByDate($month, $year){
    $navlink = 'posts';
    $this->page = 'blog';
    $totalDocs = $this->Docs->totalPosts();

        if (empty($totalDocs)) {
            $this->page = 'empty';
            $files=[$this->device.'.navbar-blog', 'post.empty'];
            $this->content = view($this->device, 'blog', $files, compact('navlink', 'page'));
        } else {
            $this->page = 'blog';
            $posts = $this->Docs->postsByDate($month, $year);
            $dates = $this->Docs->getDates();
            $files=[$this->device.'.navbar-blog', 'blog.posts', 'blog.aside', 'blog.footer'];
            $this->content = view($this->device, 'blog', $files, compact('navlink', 'posts', 'dates'));

        }
    }
*/


} // chiude classe BlogController

