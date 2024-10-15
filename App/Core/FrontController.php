<?php

namespace App\Core; 

class FrontController {
    
    public const NOT_FOUND_ACTION     = "NotFoundAction";
    public const NOT_FOUND_CONTROLLER = "App\Controllers\NotfoundController";

    private $_controller = 'product'; 
    private $_action = 'index'; 
    private $_params = []; 

    public function __construct() {
        $this->_parseUrl(); 
    }
    private function _parseUrl() {

        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = str_replace('scandiweb_test/', '', strtolower($url)); 
        $url = trim($url, '/');
        $url = explode('/', $url, 3);

        
        if ($url[0] === 'add-product' || $url[0] === 'addproduct') {
            $this->_controller = 'product';
            $this->_action = 'addProduct';
        }
        if(isset($url[1]) && $url[1] != '') {
            $this->_action = $url[1]; 
        }

        if(isset($url[2]) && $url[2] != '') {
            $this->_params = explode('/', $url[2]); 
        }

    }

    public function _dispatch() {
        
        $controllerClassName = 'App\Controllers\\' . ucfirst($this->_controller) . "Controller";
        $actionName = $this->_action . "Action"; 
        if(!class_exists($controllerClassName)) { 
            $controllerClassName = self::NOT_FOUND_CONTROLLER; 
        }
        $controller = new $controllerClassName(); 
        
        if(!method_exists($controller, $actionName)) {
            $this->_action = $actionName = self::NOT_FOUND_ACTION; 
        }

        $controller->setController($this->_controller); 
        $controller->setAction($this->_action); 
        $controller->setParams($this->_params); 
        $controller->$actionName();
    }
}

