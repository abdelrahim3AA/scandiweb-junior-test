<?php

namespace App\Controllers; 

use App\Controllers\Controller; 

class NotfoundController extends Controller
{
    public function notfoundAction() {
        return $this->_view();
    }
}