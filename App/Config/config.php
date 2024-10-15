<?php

if(!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR); 
}

define('APP_PATH', realpath(dirname(__DIR__))); 

define('VIEWS_PATH' , APP_PATH . DS . 'views' . DS); 

define('BASE_URL', 'http://localhost/scandiweb_test/');

define('PUBLIC_PATH', BASE_URL . 'Public');
