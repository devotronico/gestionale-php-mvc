<?php

/**
 * driver: il dsn viene costruito nella classe DbFactory in base al 'driver'
 * es.: se è un database mysql il dsn è:
 * 'dsn' => 'mysql:host=localhost;dbname=blog;charset=utf8'
 * altri tipi di driver sono: mysql, sqlite, mssql, oracle
 *
 * PDO::ATTR_DEFAULT_FETCH_MODE | è il modo in cui gestire i dati (array|oggetto)
 * PDO::ATTR_ERRMODE | è il modo in cui gestire gli errori
 */

// die($_SERVER['SERVER_NAME']);

if ($_SERVER['SERVER_NAME'] === 'gestionale-custom.local') {
    return [
        'driver' => 'mysql',
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'database' => 'db_gestionale',
        //'dsn' =>'mysql:host=localhost;dbname=db_gestionale;charset=utf8',
        'options' => [
            [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        ]
    ];
} else {
    return [
        'driver' => 'mysql',
        'host' => '',
        'user' => '',
        'password' => '',
        'database' => '',
          //'dsn' =>'mysql:host=localhost;dbname=db_gestionale;charset=utf8',
          'options' => [
            [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        ]
    ];
}



