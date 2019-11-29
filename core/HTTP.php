<?php

namespace Core;
use Exception;

class HTTP
{

    // private static $allowed_origins = ['lorem','ipsum',];
    private static $allowed_origins = [
        'http://gestionale-custom.local',
        'http://192.168.1.97',
        '192.168.1.97',
        'http://127.0.0.1',
        '127.0.0.1',
    ];


    public static function checkHttpOrigin() {
        if (isset($_SERVER['HTTP_ORIGIN']) === true) {
            self::async();
        } else {
            self::sync();
        }
    }

    private static function async() {
        $origin = $_SERVER['HTTP_ORIGIN'];

            if (in_array($origin, self::$allowed_origins, true) === true) {
                header('Access-Control-Allow-Origin: ' . $origin);
                header('Access-Control-Allow-Credentials: true');
                header('Access-Control-Allow-Methods: POST');
                header('Access-Control-Allow-Headers: Content-Type');
            } else {
                throw new Exception('HTTP Error: ' . $origin, -50);
            }
            // if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            //     exit; // OPTIONS request wants only the policy, we can stop here
            // }
    }

    /**
     * HTTP_HOST	192.168.1.97
     * SERVER_NAME	192.168.1.97
     * SERVER_ADDR	192.168.1.97
     * REMOTE_ADDR	192.168.1.101
     *
     * @return void
     */
    private static function sync() {
        $origin = $_SERVER['REMOTE_ADDR'];
        if (in_array($origin, self::$allowed_origins, true) === true) {
            header('Access-Control-Allow-Origin: ' . $origin);
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Allow-Methods: POST');
            header('Access-Control-Allow-Headers: Content-Type');
        } else {
            throw new Exception('HTTP Error: ' . $origin, -50);
        }
    }
}
  












