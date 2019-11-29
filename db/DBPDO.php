<?php

namespace DB;

// CLASSE SINGLETON
class DBPDO
{
    protected $conn;
    protected static $instance;

    public static function getInstance(array $options) { //l'array $options deve essere preso dal file config/database.php

        if (!static::$instance) { // se non è stata ancora inizializzata
            static::$instance = new static($options); // gli passiamo il valore dell array $options
        }
        return static::$instance; // ritorna l'array $options che ci serve per fare la connessione al database
    }

    protected function __construct(array $options) {

        $this->conn = new \PDO($options['dsn'],$options['user'],$options['password']);
        if (array_key_exists('options', $options)) {
            foreach ($options['options'] as  $opt) {
                $this->conn->setAttribute(key($opt), current($opt));
            }
        }
   }


    public function getConn() { // ritorniamo la connessione al database
        return $this->conn;
    }

}




?>