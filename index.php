<?php

namespace App;

use App\Core\FrontController;

// Load the Composer autoloader
require __DIR__ . '/vendor/autoload.php';

// Define directory separator
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load the configuration file
require_once __DIR__ . '/App/Config/config.php';

// Initialize and dispatch the front controller
try {
    $frontController = new FrontController();
    $frontController->_dispatch();
} catch (\Exception $e) {
    die('Error: ' . $e->getMessage());
}
