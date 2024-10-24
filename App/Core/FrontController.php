<?php

namespace App\Core;

class FrontController
{
    public const NOT_FOUND_ACTION     = "notFoundAction";
    public const NOT_FOUND_CONTROLLER = "App\Controllers\NotfoundController";

    private $_controller = 'product';
    private $_action = 'index';
    private $_params = [];

    public function __construct()
    {
        $this->_parseUrl();
    }

    /**
     * Parse the request URL to determine the controller, action, and parameters.
     */
    private function _parseUrl()
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Adjust the base folder if needed
        $base_url = 'http://scandiweb-dev.byethost18.com/';
        $url = str_replace($base_url, '', strtolower($url)); 
        $url = trim($url, '/');  // Remove leading and trailing slashes

        $segments = explode('/', $url);

        // Determine the controller
        $this->_controller = !empty($segments[0]) ? $segments[0] : $this->_controller;

        // Determine the action
        $this->_action = !empty($segments[1]) ? $segments[1] : $this->_action;

        // Store any additional parameters
        $this->_params = array_slice($segments, 2);

        // Handle special case for "add-product" routes
        if (in_array($segments[0], ['add-product', 'addproduct'])) {
            $this->_controller = 'product';
            $this->_action = 'addproduct';
        }
    }

    /**
     * Dispatch the request to the appropriate controller and action.
     */
    public function _dispatch()
    {
        $controllerClassName = 'App\Controllers\\' . ucfirst($this->_controller) . 'Controller';
        $actionName = $this->_action . 'Action';
        
        // Use the NotFoundController if the requested controller doesn't exist
        if (!class_exists($controllerClassName)) {
            $controllerClassName = self::NOT_FOUND_CONTROLLER;
        }

        $controller = new $controllerClassName();

        // Use the NotFoundAction if the requested action doesn't exist
        if (!method_exists($controller, $actionName)) {
            $actionName = self::NOT_FOUND_ACTION;
        }

        // Set controller, action, and parameters
        $controller->setController($this->_controller);
        $controller->setAction($this->_action);
        $controller->setParams($this->_params);

        // Call the action method
        $controller->$actionName();
    }
}
