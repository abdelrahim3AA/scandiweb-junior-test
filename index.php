<?php

namespace App;
use App\Core\FrontController;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}


require_once __DIR__ . DS . 'App' . DS . 'Config' . DS . 'config.php'; 
require_once APP_PATH . DS . 'Core' . DS . 'autoload.php';


$frontController = new FrontController();
$frontController->_dispatch();
