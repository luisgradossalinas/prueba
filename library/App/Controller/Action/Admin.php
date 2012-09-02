<?php

class App_Controller_Action_Admin extends App_Controller_Action
{

    protected $_adminLog = null;
   
    public function init()
    {
        
        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            $this->_redirect('/login');
        }
        
        
    }
}