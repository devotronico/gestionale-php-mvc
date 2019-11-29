<?php

namespace DB;
use DB\DBPDO;
// CLASSE SINGLETON


/**
* qui ci creaiamo il dsn in base al tipo di database quindi in base al valore di $options['driver'].
* esempio...se $options['driver'] = 'mysql' allora $options['dsn'] sarà 'mysql:host=localhost;dbname=blog;charset=utf8'.
* poi ritorniamo istanziando la classe DBPDO($options) che a sua volta istanzierà la classe PDO
**/
class DbFactory
{
    // Questo metodo ritorna l' array completo di $options per poterci connettere al database
    public static function Create(array $options) {

          if ( !array_key_exists('charset', $options) ){
               $options['charset'] = 'utf8';
          }

        if (!array_key_exists('dsn', $options)) {
            if (!array_key_exists('driver', $options)) {
                throw new \InvalidArgumentException('Nessun driver predefinito');
            }

            $dsn = '';
            switch ( $options['driver'] )
            {
                case 'mysql':  //   'mysql:host=localhost;dbname=blog;charset=utf8',
                case 'mssql':   //  'mssql:host=localhost;dbname=blog;charset=utf8',
                case 'oracle':   // 'oracle:host=localhost;dbname=blog;charset=utf8',
                    $dsn = $options['driver'].':host='.$options['host'].';dbname='.$options['database'].';charset='.$options['charset'];
                break;
                case 'sqllite':
                        $dsn = 'sqllite:'.$options['database'];
                break;
                default: throw new \InvalidArgumentException('Driver non riconosciuto');
            }
            $options['dsn'] = $dsn;
        }
        return DBPDO::getInstance($options); // ritorna l array $options completo
    }
}




?>