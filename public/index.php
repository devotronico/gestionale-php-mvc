<?php
// <SESSIONI>
session_start();
// if (!isset($_SESSION)) { session_start(); }
// var_dump($_SESSION);
// session_regenerate_id(true);

//echo '<pre>', print_r($_SESSION) ,'</pre>';
//echo '<pre>', print_r($_COOKIE) ,'</pre>';
/*
if (session_status() == PHP_SESSION_DISABLED) {  echo '<br> PHP_SESSION_DISABLED <br>';} // si disabilita nel file php.ini session.auto_start = "0"
if (session_status() == PHP_SESSION_NONE )    {  echo '<br> PHP_SESSION_NONE  <br>'   ;} // session_start() NON inizializzato
if (session_status() == PHP_SESSION_ACTIVE)   {  echo '<br> PHP_SESSION_ACTIVE <br>'  ;} // session_start() inizializzato
echo session_id();
*/
// </SESSIONI>


/**
 * E_ALL mostra tutti gli errori
 * in produzione passare 0 al parametro e utilizzare le eccezioni
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);


define('DS', DIRECTORY_SEPARATOR);
// define('ROOT', dirname(__FILE__));
// echo ROOT; // C:\xampp_7_3_6\htdocs\workspace\nomesito\public
// echo $_SERVER['ORIG_PATH_INFO'];
// $url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [];
// print_r($url);
// require_once(ROOT . DS . 'core' . DS . 'prova.php');






// <PATH-CONFIG>
// var_dump($_SERVER['DOCUMENT_ROOT']); // ritorna: C:/xampp_7_3_6/htdocs/workspace/nomesito/public
// die(__DIR__);                        // ritorna: C:\xampp_7_3_6\htdocs\workspace\nomesito\public
// die(dirname(__DIR__));               // ritorna: C:\xampp_7_3_6\htdocs\workspace\nomesito
// die(dirname(__FILE__));              // ritorna: C:\xampp_7_3_6\htdocs\workspace\nomesito\public
/**
 * DA LOCALE
 * Se si vuole settare il percorso nomesito/public/index.php come punto di ingresso senza utilizzare il file .htaccess
 * col terminale spostarsi nella cartella superiore del progetto
 * se ci si trova in locale utilizzando xampp, la cartella superiore è /htdocs/
 * In questo punto digitare nel terminale il comando:
 * php -S localhost:3000 -t nomesito/public
 * Nel browser digitare:   http://localhost:3000
 */

/**
* Avendo spostato il punto di ingresso nella sottocartella:   'nomesito\public\index.php'
* per caricare i file che si trovano nelle altre cartelle allo stesso livello di 'nomesito\public\'
* per esempio la cartella 'nomesito\app\' o la cartella 'nomesito\config\'
* bisogna uscire dalla cartella portandoci a un livello superiore e poi entrare nella cartella desiderata
* per fare ciò bisogna anteporre ad 'app/controller/Controller.php' questa stringa '../'
* Esempio:   require_once '../app/controller/Controller.php';
* ma per comodità e` meglio utilizzare la sintassi:   require_once 'app/controller/Controller.php';
* per fare ciò utilizzare il comando:   chdir(dirname(__DIR__))
*/

/**
 * https://www.php.net/manual/en/function.chdir.php
 * La funzione chdir(dirname(__DIR__)) setta come root la
 * cartella principale del progetto/sito  dirname(__DIR__) = C:\xampp\htdocs\nomesito
 * In questo modo se si vuole fare il require del file index.tpl.php si deve scrivere
 * require 'layout/index.tpl.php'; invece di require '../layout/index.tpl.php';
 */
chdir(dirname(__DIR__)); // setta questa cartella(public) come quella predefinita per fare il require dei file
// </PATH-CONFIG>



/**
 * Carica tutte le classi e le funzioni
 */
require 'core/bootstrap.php';

/**
 * prende i valori del database richiesti per fare la connessione
 */
$databaseConfig = require 'config/database.php';

/**
 * $appConfig è un array
 */
$appConfig = require 'config/app.config.php';


try {

    try {
        Core\HTTP::checkHttpOrigin();

        $mark = new Helpers\ExecutionTime();
        $mark->start();

        $pdoConn = DB\DbFactory::Create($databaseConfig);

        $conn = $pdoConn->getConn(); // otteniamo la connessione al database

        //ROTTE
        $router = new Router($conn);

        //$router->loadRoutes($appConfig['routes']);
        $router->loadRoutes($appConfig);

        // dispatch chiama un metodo della classe PostController  //la classe PostController viene istanziata nella classe Router
        $controller = $router->dispatch();

        // $test = '';
        // if (is_null($controller)) { $test .= '<br>null'; }
        // if (isset($controller)) { $test .= '<br>settata'; }
        // if (!$controller) { $test .= '<br>false'; }
        // if (empty($controller)) { $test .= '<br>empty'; }
        // echo $test;

       // if (isset($controller)) { // TESTING
        $controller->display();
       // }  // TESTING


        // die('Errore: classe Log non trovata');

        // <LOG-USER>
        // $userData = [
        //     "name" => $name,
        //     "email" => $email,
        //     "password" => $password
        // ];
        // $logB = Log::setSingleton();
        // $logB->createLogUser('user', $userData);
        // </LOG-USER>

        // <LOG-PERFORMANCE>
        $mark->end();
        $diff = $mark->diff();
        $logC = Helpers\Log::setSingleton();
        $logC->createLogPerf('perf', $diff);
        // </LOG-PERFORMANCE>

    } catch (\PDOException $e) {
        throw new Core\MyException($e->getMessage(), -30, $e);
    }   catch (Exception $e) {
        throw new Core\MyException($e->getMessage(), $e->getCode(), $e);
    }

} catch (Core\MyException $myException) {
    $data = $myException->getData();
    $type = $myException->getTypeOfError();
    $logA = Helpers\Log::setSingleton();
    $logA->createLogError($type, $data);

    $myException->showError();

    // if ($myException->isAsync()) {
    //     echo $myException->getMessage();
    // } else { // die('test');
    //     echo $myException->createErrorTemplate($data);
    // }
}




