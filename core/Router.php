<?php

class Router
{
    protected $conn;

    protected $routes = [
        'GET' => [],
        'POST' => [],
    ];


    public function __construct(\PDO $conn){

        $this->conn = $conn;
    }


    /**
     * inizializzia l'array $routes con i dati presi dal file 'config/app.config.php'
     *
     * @param array $routes
     * @return void
     */
    public function loadRoutes(array $routes){
        $this->routes = $routes;
    }


    /**
     * Se l'utente non si e` autenticato non puo` accedere a tutte le pagine del gestionale
     * [a] Se la variabile  $_SESSION['authenticated'] non e` true
     * [b] $freeUriList: lista di rotte libere che anche se l'utente non e` autenticato puo` accedere
     * [c] Se la rotta e` diversa da quelle libere
     * [d] L'utente viene reinderizzato alla pagina del login
     * @param [type] $uri - rotta dell' url
     * @return void
     */
    private function lockSomeUri($uri) {
        if (!isUserAuthenticated()) { // [a]
            $freeUriList = ['', '/', '/auth/signin', '/auth/signup', '/auth/signin/access', '/auth/signup/store', '/auth/signup/verify']; // [b]
            if (!in_array($uri, $freeUriList, true)) { // [c]
                redirect('/auth/signin'); // [d]
            }
        } else {
            $hideUriList = ['/auth/signin', '/auth/signup', '/auth/signin/access', '/auth/signup/store', '/auth/signup/verify']; // [b]
            if (in_array($uri, $hideUriList, true)) { // [c]
                redirect('/'); // [d]
            }
        }
    }

    // NON FUNZIONA
    /*
    public function handleOldStructure($uri) {
        if (preg_match('/\/test\/[a-z]+\.php/', $uri, $matches)) {
            // header('Location: ' . $matches[0]);
            // die;
            // return true;
        }
    }
    */

    /**
     * Legge l URL
     * questo metodo ci da GET/POST e la Path es. 'post/2'
     * [a] Elimina il nome di dominio e le variabili dall 'url completo
     * - $_SERVER['REQUEST_URI'] restituisce la stringa dopo il nome di dominio,
     *   - es. da 'sito.it/pag?nome=max' ottiene solo '/pag?nome=max'
     * - Con parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
     *   - in 'sito.it/pag?nome=max' restituisce solo '/pag'
     *
     * [b] elimina il carattere '/' all'inizio e alla fine della stringa
     *     es. '/post/2' diventa 'post/2'
     * [c]  ottiene il metodo POST o GET
     * @return void
     */
    public function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // [a]
        $this->lockSomeUri($uri);
        $uri = trim($uri, '/'); // [b]
        $method = $_SERVER['REQUEST_METHOD']; // [c]
        return $this->processQueue($uri, $method);
    }


    /**
     * [d] Il metodo viene passato come indice all'array routes
     * [e] Cicla tutti gli Indici GET oppure POST dell' array routes
     * per controllare se la rotta esiste e
     * quindi richiamare la classe e il metodo corrispondente
     * Esempio con metodo GET
     * $route(indice) = post/:id
     * $callback(valore) = App\Controllers\PostController@create
     *
     * @param [type] $uri
     * @param string $method
     * @return void
     */
    protected function processQueue($uri, $method='GET') {
        $routes = $this->routes[$method]; // [d]
        foreach ($routes as $route => $callback) {

            $hasPlaceholder = false;
            if (substr($route, 0, 1) === '#' ) {
                $route = substr($route, 1);
                $hasPlaceholder = !$hasPlaceholder;
            }

            if ($hasPlaceholder) {
                /**
                 * preg_quote fa l escape ai caratteri. Es.: post/:id diventa post/\:id
                 * I caratteri speciali per le espressioni regolari sono . + * ? [ ^ ] $ ( ) { } = ! < > | :
                 */
                $route = preg_quote($route);

                /**
                 * Se la rotta ha il carattere ':' seguito da una serie di caratteri alfanumerici
                 * La parte '\:id' in 'post/\:id' viene sostituita da '([a-zA-Z0-9\-\_]+) e diventa 'post/([a-zA-Z0-9\-\_]+)
                 * arg 1 = Pattern di ricerca -----> '/\\\:[a-zA-Z0-9\_\-]+/'
                 * arg 2 = La stringa sostitutiva -> '([a-zA-Z0-9\-\_]+)'
                 * arg 3 = Stringa da modificare --> 'post/\:id'
                 * $route = 'post/([a-zA-Z0-9\-\_]+)'
                 *
                 * se una parte della stringa nella variabile $route corrisponde al primo argomento
                 * quella parte viene sostituita dal secondo argomento
                 * Es. Il primo argomento '/\\\:[a-zA-Z0-9\_\-]+/' , in $route = ''post/\:id', trova corrispondenza in '\:id'
                 * preg_replace ( pattern di ricerca, con cosa sostituire, dove cercare )
                 */
                $route = preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', $route);
            }


            /**
             * Preparare la variabile '$route' per confrontarla con la variabile $uri
             * la stringa 'post/([a-zA-Z0-9\-\_]+)' non può avere come delimitatori il carattere '/' perchè
             * lo stesso carattere è all'interno della stringa
             * Quindi la stringa 'post/([a-zA-Z0-9\-\_]+)' viene delimitata con
             * un altro carattere non alfanumerico. es. il carattere '@'
             * $route: @^post/([a-zA-Z0-9\_\-]+)$@
             */
            $route = "@^". $route. "$@";


            /**
             * A questo punto la rotta che e` stata modificata per utilizzarla come pattern di ricerca
             * per trovare corrispondenza nella variabile $#uri
             * arg 1 = $route   = Il pattern di ricerca ->  '@^post/([a-zA-Z0-9\_\-]+)$@'
             * arg 2 = $uri     = La stringa dell' url -->  'post/2'
             * arg 3 = $matches = Array di ritorno ------>  [0 => 'post/2',   1 => '2']
             */
            $matches = [];
            if (preg_match($route, $uri, $matches)) {

                // rimuove il primo elemento dell'array {'post/2'} perchè non è utilizzabile per passarlo come parametro del metodo
                // ci teniamo il secondo elemento dell'array {'2'} per passarlo come parametro del metodo della classe che chiameremo
                // se il path è 'posts' allora $matches[0] = 'posts' e $matches[1] = null
                // si può passare un argomento null anche se il metodo non vuole nessun argomento
                array_shift($matches); // elimina $matches[0] = 'post/2' e quindi rimane solo $matches[1] = '2'
                return $this->callMethod($callback, $matches);
            }
        }
        /**
         * se la uri non coincide con nessuna rotta allora l'utente viene portato in una pagina di errore 404
         */
        $callback = 'App\Controllers\Controller@error404';
        return $this->callMethod($callback);
    }




    /**
     * // TODO: ottimizzare/sostituire call_user_func_array con una tecnica più veloce, info: https://gist.github.com/nikic/6390366
     *
     *
     * @param [type] $callback
     * @param array $matches
     * @return void
     */
    protected function callMethod($callback, array $matches=[]) {
        if (is_callable($callback)) { //se trova la funzione
            die('Errore in classe '.__CLASS__.' metodo '.__METHOD__);
            // al momento non si attiva mai perchè non esitono funzioni tipo come App\Controllers\PostController@getPosts'
            // dobbiamo spezzare dove sta il simbolo '@' per ricavarne il metodo
            return call_user_func_array($callback, $matches);
        }
        $tokens = explode('@', $callback); // es. spezziamo 'App\Controllers\PostController@getPosts',
        $controller = $tokens[0]; // assegniamo a $controller la classe PostController
        $method = $tokens[1]; // assegniamo a $method il metodo della classe PostController
        $class = new $controller($this->conn); // creiamo un istanza della classe PostController

        if(method_exists($controller, $method)){ // Se il metodo trovato esiste

            call_user_func_array([$class, $method], $matches); //es. ([PostController, delete], 8)

            return $class;
        } else {
            throw new Exception('Il metodo '.$method.' non esiste nella classe '.$controller, -20);
        }
    }

}  // chiude classe Router