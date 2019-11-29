<?php
declare(strict_types=1);
//*******|*********|*********|*********|*********|*********|*********|*********|*********|*********|

/**
 * funzione richiamata dalle classi controller per caricare i template
 * [a] Estrae i dati contenuti nell'array data, convertendoli in normali variabili
 * per inserirli nei template
 * [b] I dati appena estratti li mette nel buffer
 * [c] Cicla l'array $files che contiene una lista di nomi di template da concatenare al percorso
 * del file da richiamare
 * [d] Cattura tutto il contenuto dei template con le variabili dentro
 * [e] Libera la memoria
 *     ? meglio disattivare altrimenti non ritorna $data ?
 * [f] ritora tutto l'output che verrà assegnato alla variabile $content della classe controller
 * che tramite il metodo display la richiamerà nel template layout
 * @param string $device - prima sottocartella di views (desktop|mobile)
 * @param string $view - seconda sottocartella (auth|docs|blog)
 * @param array $files - nome dei file dei template
 * @param array $data - dati per popolare i template
 * @return string
 */
function view(string $device, string $view, array $files=[], array $data=[]):string {
  extract($data); // [a]
  ob_start(); // [b]
  foreach ($files as $file) { require 'app/views/'.$device.'/view-'.$view.'/'.$file.'.tpl.php'; } // [c]
  $output = ob_get_contents(); // [d]
  ob_end_clean(); // [e]
  // var_dump($output);
  return $output; // [f]
}



function redirect($uri ='/', $message='') {
  $mess = !empty($message) ? '?message='.urlencode($message): '';
  header('Location:'.$uri.$mess);
  die(); // die è più veloce di exit
}




function isUserAuthenticated() {
  return $_SESSION['authenticated'] ?? false;
}

function getUserName() {
  return $_SESSION['name'] ?? '';
}

function getUserId() {
  return $_SESSION['id'] ?? '';
}

function getUserRole() {
  return $_SESSION['roletype'] ?? '';
}

function getUserEmail() {
  return $_SESSION['email'] ?? '';
}

function isUserAdmin() {
  return getUserRole() === 'admin';
}

// possono avere accesso sia l' admin e che l' ordinary
function userCanAccess() {
  $role = getUserRole();
  return $role === 'admin' || $role === 'ordinary';
}

function userCanDelete() {
  return isUserAdmin();
}





function dateFormatted($dateOld) {

 $temp = preg_split("/[-\s:]/", $dateOld);

 $temp[2] = ltrim($temp[2], '0' );

 switch($temp[1]){
     case '01': $temp[1]  = 'gennaio'; break;
     case '02': $temp[1]  = 'febbraio'; break;
     case '03': $temp[1]  = 'marzo'; break;
     case '04': $temp[1]  = 'aprile'; break;
     case '05': $temp[1]  = 'maggio'; break;
     case '06': $temp[1]  = 'giugno'; break;
     case '07': $temp[1]  = 'luglio'; break;
     case '08': $temp[1]  = 'agosto'; break;
     case '09': $temp[1]  = 'settembre'; break;
     case '10': $temp[1]  = 'ottobre'; break;
     case '11': $temp[1]  = 'novembre'; break;
     case '12': $temp[1]  = 'dicembre'; break;

 }

  $dateNew = $temp[2].' '.$temp[1].' '.$temp[0].' , '.$temp[3].':'.$temp[4];

  return $dateNew;
}


function truncate_words($text, $limit, $ellipsis=' ...') {
  $words = preg_split("([\s])", $text, $limit + 1, PREG_SPLIT_NO_EMPTY);
  if ( count($words) > $limit ) {
      array_pop($words);
      $text = implode(' ', $words);
      $text = $text . $ellipsis;
  }
  return $text;
}
