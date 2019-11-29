<?php

namespace Core;
// use Throwable; // PHP 7
use Exception;

/**
 * Classe customizzata per gestire le eccezioni
 * Estende la classe interna di php Exception
 *  die('{"":""}');
 */
class MyException extends Exception
{
    private $myMessage;
    private $myCode;
    private $previous;
    private $request;
    private $exceptionClass;
    private $data;
    private $arrHead = [];
    private $arrBody = [];

    private $test = 1234567489;

    /**
     * Undocumented function
     *
     * @param mixed $myMessage: messaggio di errore. può essere una stringa o un array se sono più errori
     * @param integer $myCode: [ (da -10 a -19 -> errori utente) | (da -20 a -29 errori programmazione) | (da -30 a -39 errori databse) ]
     * @param Exception $previous: da commentare
     * @param string $request: Il tipo di chiamata HTTP. può assumere solo due valori: sync|async
     * @param string $section: In linea generale è la sezione del programma, dove si è verificato l'errore.
     *                         Viene utilizzato per creare il nome delle cartelle dei file di log
     * @param string $action:  Descrive più precisamente il tipo di errore.
     */
    public function __construct($myMessage, int $myCode=0, Exception $previous=null ) {

        $this->myMessage = $myMessage;
        $this->myCode = $myCode;
        $this->previous = $previous;
        $this->exceptionClass = get_class($previous);

        $headers = getallheaders();
        $this->request = strtoupper($headers['HTTP_X_REQUESTED_WITH'] ?? 'NORMAL'); // XMLHttpRequest  XMLHTTPREQUEST

        switch ($myCode) {
            case 0: $arr = $this->getTestError(); break; // user
            case -10: $arr = $this->getUserError('email'); break; // user
            case -11: $arr = $this->getUserError('password'); break; // user
            case -15: $arr = $this->getUserMultiError(); break; // user multierror
            case -20: $arr = $this->getDevError(); break; // php
            case -30: $arr = $this->getDatabaseError(); break; // db
            case -40: $arr = $this->getHacking(); break; // hacking
            case -50: $arr = $this->getHttpError(); break; // php
        }
        $this->getHeadError();

        $this->data['head'] = $this->arrHead;
        $this->data['body'] = $this->arrBody;
        $jsonstring = json_encode($this->data, JSON_UNESCAPED_UNICODE);
        parent::__construct($jsonstring, $myCode, $previous);
    }

/*
public function isAsync() {
    if ($this->request === 'XMLHTTPREQUEST') {
        return true;
    }
    return false;
}
*/


    public function showError() {
        if ($this->request === 'XMLHTTPREQUEST') {
            echo parent::getMessage();
        } else { // die('DIEEEEEE');
           echo require 'layout/error/error.tpl.php';
        }
    }


    private function createErrorTemplate(array $data) {
        
        require 'layout/error/error.tpl.php';
    }

    /**
     * Questo metodo è utilizzato per estrapolare lista di informazioni sull' errore che si è verificato
     * Viene richiamato solo nel file index.php per passare il valore di ritorna alla
     * classe Log e viene utilizzato dalla stessa per creare i file json dei log
     * @return array - lista di informazioni sull' errore
     */
    public function getData() {
        return $this->data;
    }


    /**
     * Questo metodo è utilizzato per estrapolare il tipo di errore che si è verificato
     * Viene richiamato solo nel file index.php per passare il valore di ritorna alla
     * classe Log e viene utilizzato dalla stessa per creare le cartelle dei log a seconda
     * del tipo di log in modo da separare i vari tipi di file json dei log
     * @return string - tipo di errore
     */
    public function getTypeOfError() {
        return $this->arrHead['section'];
        // return $this->section;
    }


    private function getTestError() {
        $this->arrHead['status'] = 'error';
        $this->arrHead['section'] = 'auth';
        $this->arrBody['dom'] = 'email';
        $this->arrBody['message'] = $this->myMessage;
    }


    private function getUserError(string $dom) {
        $this->arrHead['status'] = 'error';
        $this->arrHead['section'] = 'auth';
        $this->arrBody['dom'] = $dom;
        $this->arrBody['message'] = $this->myMessage;
    }


    private function getUserMultiError() {
        $this->arrHead['status'] = 'error';
        $this->arrHead['section'] = 'auth';
        $this->arrBody = json_decode($this->myMessage);
        // $this->arrBody = $this->myMessage;
    }

    // -20
    private function getDevError() {
        $this->arrHead['status'] = 'error';
        $this->arrHead['section'] = 'auth';
        $this->arrBody['message'] = $this->myMessage;
    }


    // -30
    private function getDatabaseError() {
        $this->arrHead['status'] = 'error';
        $this->arrHead['section'] = 'auth';
        $this->arrBody['message'] = $this->myMessage;
    }

    // -40
    private function getHacking() {
        $this->arrHead['status'] = 'hacking';
        $this->arrHead['section'] = 'auth';
        $this->arrBody['message'] = $this->myMessage;
    }

    // -50
    private function getHttpError() {
        $this->arrHead['status'] = 'error';
        $this->arrHead['section'] = 'auth';
        $this->arrBody['message'] = $this->myMessage;
    }

    /**
     * Ritorna l'array head che contiene la lista di informazioni comuni
     * per tutti i tipi di errori
     * @return array
     */
    private function getHeadError() {
        $this->arrHead['request'] = $this->request;
        $this->arrHead['date'] = date("YmdHis");
        $this->arrHead['code'] = $this->myCode;
        $this->arrHead['exception'] = $this->exceptionClass;
        $this->arrHead['file'] = $this->previous->getFile();
        $this->arrHead['line'] = $this->previous->getLine();
        $this->arrHead['function'] = $this->previous->getTrace()[0]['function'];
        $this->arrHead['class'] = $this->previous->getTrace()[0]['class'];
    }


/*
    private function getDevError() {
        //$this->arrHead['path'] = $this->getFile();
        if(isset($this->getTrace()[0]['class'])) { $this->arrHead['class'] = $this->getTrace()[0]['class']; }
        if(isset($this->getTrace()[0]['function'])) { $this->arrHead['function'] = $this->getTrace()[0]['function']; }
        if(isset($this->getTrace()[0]['type'])) { $this->arrHead['type'] = $this->getTrace()[0]['type']; }
        if(isset($this->getTrace()[0]['args'])) { $this->arrHead['args'] = $this->getTrace()[0]['args']; }
        //$this->arrHead['file'] = basename($this->getFile());
        $this->arrHead['line'] = $this->getLine();

        $this->arrBody = $this->myMessage;
    }
    */

/*
private function writeErrorLog(array $arr){


    $baseURL = $_SERVER['DOCUMENT_ROOT'] . '/login-system/'; // C:/xampp/htdocs

    $annoCorrente = date("y"); // 19
    $meseCorrente = date("m"); // 01
    $file_Json = '/log_' . $this->action . '.json';
    $filename = $baseURL . 'logs/' . $annoCorrente . '/' . $meseCorrente . $file_Json;


    if(!is_dir(dirname($filename))) {   // die('{ "status": "test", "num": "1" }'); // DEBUG C:/xampp/htdocs

        mkdir(dirname($filename).'/', 0777, TRUE);

        $arrayOfArr[] = $arr;

    } else {   // die('{ "status": "test", "num": "2" }');

        $jsonstring = file_get_contents($filename); // Save contents of file into a variable

        $arrayOfArr = json_decode($jsonstring, true);

        array_push($arrayOfArr, $arr);
    }

    $jsonstring = json_encode($arrayOfArr, JSON_UNESCAPED_UNICODE, JSON_PRETTY_PRINT);

    file_put_contents($filename, $jsonstring);

    //file_put_contents($filename, $jsonstring.PHP_EOL, FILE_APPEND | LOCK_EX);
}

*/



}







