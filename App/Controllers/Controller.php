<?php

namespace App\Controllers; 

class Controller
{
    const NOT_FOUND_ACTION = "NotFoundAction"; 
    const NOT_FOUND_CONTROLLER = "App\Controllers\NotfoundController"; 

    private $_controller; 
    private $_action; 
    private $_params; 

    public function NotFoundAction() {
        $this->_view(); 
    }

    /// setting Function
    public function setController($controllerName) {
        $this->_controller = $controllerName; 
    }

    public function setAction($actionName) {
        $this->_action = $actionName; 
    }

    public function setParams($params) {
        $this->_params = $params; 
    }

    protected function _view($_data = NULL) {
         
        if($this->_action ==  self::NOT_FOUND_ACTION) //// index => default
        {
            require_once VIEWS_PATH . 'notfound' . DS . 'notfound.view.php';
        }
        else 
        {
            $view = VIEWS_PATH . $this->_controller . DS . $this->_action . '.view.php';
        
            if(file_exists($view)) 
            {
                extract($_data);
                require_once $view; 
            } else {
                require_once VIEWS_PATH . 'notfound' . DS . 'notfound.view.php';
            }
        }
            
    }
}           
    
