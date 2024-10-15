<?php

namespace App\Core; 

class Autolaod {

    public static function autoload($className) {

        $className = str_replace('App', '', $className);
        $className = str_replace('\\', '/', APP_PATH . $className); 
        $className = strtolower($className);
        $className.='.php';
        if(file_exists($className)) {
            require $className; 
        }
    }
}
spl_autoload_register(__NAMESPACE__ . '\Autolaod::autoload'); 