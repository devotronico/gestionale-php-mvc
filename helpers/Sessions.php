<?php

namespace Helpers;

/**
 *  $_SESSION[roletype]: admin|
 */
class Sessions
{
    public static function setSession($data) {
        session_regenerate_id(); // ok
        setcookie('cookie_id', $data['id'], time()+3600, '/');
        $_SESSION['authenticated'] = true;
        if (is_object($data) || is_array($data)) {
            foreach ($data as $key => $value) {
                $acceptedKey = array('id', 'roletype', 'name', 'email');
                if (in_array($key, $acceptedKey, true)) {
                    $_SESSION[$key] = $value;
                }
            }
        } else {
            throw new \Exception('il parametro passato non è un array o un oggetto', -20);
        }
    }
}







