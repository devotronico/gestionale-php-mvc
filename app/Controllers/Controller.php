<?php

namespace App\Controllers;

use \PDO;

class Controller {
    //$layout = { contiene tutta la pagina html e la variabile $content }
    protected $layout; // percorso del layout completo
    //$content = viene chiamato nel template 'layout/index.tpl.php' e visualizza il contenuto della pagina {template e variabili}
    protected $content; // $content
    //$page =  home || blog || auth { è il nome della cartella da cui vengono presi i template } \app\views\view-$page\file.tpl.php
    protected $page;
    //$device =  mobile || desktop {serve a separare file e template a seconda se siamo su un dispositivo desktop o mobile }
    protected $device;
    //$navbar =  { identifica il file CSS della NAVBAR da linkare nel template a seconda del dispositivo e della pagina }
    protected $navbar;
    //$style =  { identifica il file CSS da linkare nel template a seconda del dispositivo e della pagina }
    protected $style;
    //$script =  { identifica il file JS da linkare nel template a seconda del dispositivo }
    protected $script;
    //$script =  { identifica il file immagine da linkare nel template a seconda del dispositivo }
  //  protected $photo;
    //$grid =  { serve a identificare la classe bootstrap .container-fluid utilizzata nei template home e .container in blog e auth }
   // protected $grid = 'container';

    protected $conn;


// public function __construct(PDO $conn){
// $this->conn = $conn; // otteniamo la connessione con la quale possiamo fare le query al database
public function __construct() {
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
        $this->device = 'mobile';
    } else {
        $this->device = 'desktop';
    }
}


/***************************************************************************|
* DISPLAY                                                                   |
* la variabile 'layout' contiene il file 'layout/index.tpl.php' che mostra  |
* il layout completo che è sempre uguale per ogni pagina del sito.          |
* All' interno del file 'layout/index.tpl.php' cè la variabile 'content'    |
* che contiene un template diverso in base alla rotta che c'è nell'url      |
****************************************************************************/


/**
 * [a] script: in tutte le pagine il file javascript principale è sempre main.js
 *
 * @return void
 */
public function display() {
    $this->layout = 'layout/index.tpl.php';
    $this->script = 'main';
    $this->style = $this->page; // è il file css da caricare
    require $this->layout;
}


public function error404() {
    $this->page = 'error404';
    $messageError = 'questa pagina non esiste';
    $files = ['navbar', $this->page];
    $this->content = view($this->device, 'home', $files, compact('messageError'));
}



}