<?php

namespace Helpers;

/**
 * Fa la validazione di: name, email, password, hashEmail, phone, token
 * @author Daniele Manzi <dmanzi83@gmail.com>
 * @category helper
 * @return mixed
 * @see
 * @since 1.0.0
 * @global
 */
class Validation
{

    private $data;
    private $message = [];

    public function __construct($data) {
        if (is_object($data) || is_array($data)) {
            $this->data = $data;
        } else {
            throw new \Exception('il parametro passato non è un array o un oggetto', -20);
        }
    }

    public function validate() {
        foreach ($this->data as $key => $value) {
            $this->$key(...[$value]);
        }

        // foreach ($this->data as $key => $value) {
        //     switch ($key) {
        //         case 'name': $this->validateName($value); break;
        //         case 'email': $this->validateEmail($value); break;
        //         case 'password': $this->validatePassword($value); break;
        //         case 'hash': $this->validateHash($value); break;
        //     }
        // }

        if (!empty($this->message)) { return false; }
        return true;
    }



    /**
     * Questo metodo viene richiamato solo per ottenere la lista di errori
     * da passare come primo parametro alla classe MyException
     * @return array - lista di errori
     */
    public function getAllErrors() {
        return json_encode($this->message, JSON_UNESCAPED_UNICODE);
        //return $this->message;
    }


    /**
     * VALIDATE EMAIL BASE
     *
     * varie espressioni regolari per validare l' email ma nessuna di esse include tutte le varianti di email al mondo:
     * [1] /^([a-zA-Z0-9\.\-]+)@([a-zA-Z0-9\.\-]+)\.([a-z]{2,20})(.[a-z]{2,8})?$/
     * [2] /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/
     * [3] /^[-!#$%&'+/0-9=_A^AZ-z{|}?~].?!(\[-#$%&'?+/0-9= _A^AZ-z{|}~])*@[a-zA-Z](-?[a-zA-Z0-9])*(\.[a-zA-Z](-?[a-zA-Z0 -9])*)+$/
     *
     * link utili:
     * https://stackoverflow.com/questions/2049502/what-characters-are-allowed-in-an-email-address
     * https://en.wikipedia.org/wiki/Email_address#Local-part
     * https://stackoverflow.com/questions/201323/how-to-validate-an-email-address-using-a-regular-expression
     *
     * Local-part, ovvero PRIMA della chiocciola sono consentiti i caratteri:
     * [1]: da 'A' a 'Z', da 'a' a 'z', da '0' a '9'
     * [2]: i caratteri speciali: !#$%&'*+-/=?^_`{|}~;
     *      Il punto., a condizione che non sia il primo o l'ultimo carattere se non quotato,
     *      e purché non appaia consecutivamente a meno che non sia quotato
     *      (ad es. John..Doe@mail.com non è permesso ma "John..Doe"@mail.com è permesso);
     * [3]: spazio e caratteri: "(),:; <> @ [\] sono consentiti con restrizioni
     *      (sono consentiti solo all'interno di una stringa quotata, come descritto nel paragrafo seguente,
     *      e inoltre, una barra rovesciata o una virgoletta deve essere preceduta da una barra rovesciata);
     *
     * Domain, ovvero DOPO la chiocciola sono consentiti i caratteri:
     * [1]: da 'A' a 'Z', da 'a' a 'z', da '0' a '9'
     * [2]: e il trattino (-)
     * [3]: NON possano iniziare con una cifra o con un trattino e non devono terminare con un trattino.
     *      Non sono consentiti altri simboli, caratteri di punteggiatura o spazi vuoti.
     *
     * DESCRIZIONE FUNZIONE:
     * fa una prima validificazione del 'email
     * Controlla: che non sia vuota e che abbia caratteri validi
     * FILTER_SANITIZE_EMAIL ( http://php.net/manual/en/filter.examples.sanitization.php )
     * Rimuove tutti i caratteri eccetto le lettere, i numeri e i caratteri !#$%&'*+-/=?^_`{|}~@.[]
     * Non sono considerate valide le email con i caratteri "\<>
     * ma lascia le virgolette singole ['] perciò non è sufficiente.
     * Se l'email contiene il carattere '/' verrà ritenuta valida ma il carattere '/' verrà rimosso
     * HTML5 non considera valide le email con i caratteri:
     * prima e dopo la chiocciola  @()[]:<>\"
     * prima della chiocciola      @()[]:<>\"
     * dopo la chiocciola          @$%&'*+/=?^_`{|}~()[]:<>\"
     *
     * TEST
     * Carattere 	Valido			        Non valido 	    Info
     * #	  	    #da#s@mail.it		    dan@mail.i#t	non deve stare dopo il carattere @
     * @			                        d@an@mail.it  	può esserci solo un carattere @
     * []					                d[an@mail.it 	mai valido
     * (		    (1)((@)2().())a)))()			        vengono rimosse le parentesi da FILTER_SANITIZE_EMAIL
     * )		    (f)((@)a().())t)))()			        vengono rimosse le parentesi da FILTER_SANITIZE_EMAIL
     */
    private function email($email) {
        $email = trim($email);
        if (empty($email)) {
            $this->message[] = ['dom' => 'email', 'message' => 'Il campo email è vuoto'];
        } else {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL); // sanitized_email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $this->message[] = ['dom' => 'email', 'message' => $email .' non è un email valida'];
            }
        }
    }



/**
 * VALIDATE PASSWORD
 * Se presenti vengono eliminati gli spazi prima e dopo la password
 * Controlla se il valore della password è vuoto, ovvero se la password è stata digitata dall' utente
 * Controlla la lunghezza della password
 */
    private function password($password) {
        $PASSWORD_LENGTH = 8;
        $password = trim($password);
        if (empty($password)) {
            $this->message[] = ['dom' => 'password', 'message' => 'Il campo password è vuoto'];
        } else if (strlen($password) < $PASSWORD_LENGTH) {
            $this->message[] = ['dom' => "password", 'message' => 'La password deve avere almeno '. $PASSWORD_LENGTH .' caratteri'];
        }
    }



/**
 * VALIDATE NAME
 * fa la validazione al nome dell' utente
 * TO-DO: validare anche i simboli: ' "
 * $illegal = "#$%^&*()+=-[]';,./{}|:<>?~";
 * echo (false === strpbrk($YourCsvVarible, $illegal)) ? 'Allowed' : "Disallowed";
 * $illegal = "€#$%^&*()+=-[]';,./{}|:<>?~";
 * $illegal = "@[\€\#\$\%\@\^\&\*\(\)\+\=\-\[\]\'\;\,\.\/\{\}\|\:\<\>\?\~]@"
 */
    private function name($name) {
        if (empty($name)) {
            $this->message[] = ['dom' => 'name', 'message' => 'Il campo nome è vuoto'];
        } else {
            // $illegal = "/\W/";
            // $illegal = "/\€/";
           $illegal = "/[\€\#\$\%\@\^\&\*\(\)\+\=\-\[\]\'\;\,\.\/\{\}\|\:\<\>\?\~]/u";
            if (preg_match_all($illegal, $name, $output_array)) {
                $char_listA = $output_array[0];
/*
                $fn = function (string $char) {

                   // return (string)$char;
                    return utf8_encode((string)$char); // funziona
                   // return iconv('Windows-1252', 'UTF-8', $char);
                   // return iconv("UTF-8", "ISO-8859-1//IGNORE", $char);
                    // return utf8_encode((string)$n);
                };

                $char_listB = array_map($fn, $char_listA);
                */
                $chars = '<b>' .implode('</b> , <b>', $char_listA) . '</b>';
               // $chars = utf8_encode((string)$chars);
                if (count( $output_array[0]) > 1) {
                    $this->message[] = ['dom' => 'name', 'message' => 'I caratteri: '. $chars .' non sono validi'];
                } else {
                    $this->message[] = ['dom' => 'name', 'message' => 'Il carattere '. $chars .' non è valido'];
                }
            }
            /*

            if (preg_match($illegal, $name, $matches)) {

                $this->message[] = ['dom' => 'name', 'message' => 'Il carettere '. $matches[0] .' non è valido'];
            }
            */
        }
    }


    /**
     * VALIDATE HASH [metodo GET]
     * Controlla la validità del codice hash che proviene dall' email che si è inviato
     * all' utente durante la fase di registrazione del suo account
     * Controlla se sono validi i caratteri che compongono l' hash che otteniamo dall' url
     */
    private function hashEmail($hash) {
        if (!preg_match('/^[a-f0-9]{32}$/', $hash)) {
            $this->message[] = ['dom' => 'hash', 'message' => 'il parametro hash non è valido'];
        }
    }


    /**
     * VALIDATE PHONE
     * Controlla se il numero di telefono immesso
     * dall' utente sia valido
     */
    private function phone($num) {
        if (empty($num)) {
            $this->message[] = ['dom' => 'phone', 'message' => 'Il campo telefono è vuoto'];
        } else if (!preg_match('/^[0-9]{15}$/', $num)) {
            $this->message[] = ['dom' => 'phone', 'message' => 'numero di telefono invalido'];
        }
    }


    /**
     * l'espressione regex è uguale a quella utilizza nella funzione hashEmail
     * ma cambia la lunghezza della stringa da 32 a 64
     * $token = 649315747a2e15e0f916d63a4b4949e99f2fcb3ba09503ed3b2fd97ddaf10f47
     * @param [string] $token
     * @return void
     */
    private function token($token) {
        if (!preg_match('/^[a-f0-9]{64}$/', $token)) {
            $this->message[] = ['dom' => 'token', 'message' => 'il parametro token non è valido'];
        }
    }



} // CHIUDE CLASSE
