<?php
// Define the directory separator if not already defined
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

// Define the base path of the application
define('APP_PATH', realpath(dirname(__DIR__)));

// Define the path for views
define('VIEWS_PATH', APP_PATH . DS . 'Views' . DS);

// Define the base URL for the project
define('BASE_URL', 'http://scandiweb-dev.byethost18.com/');

// Define the public path URL for assets like CSS, JS, and images
define('PUBLIC_PATH', BASE_URL . 'Public/');

// Optional: Set error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
if(!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR); 
}


