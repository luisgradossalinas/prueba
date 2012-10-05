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
        
        $sesion_usuario = new Zend_Session_Namespace('sesion_usuario');
        
        Zend_Layout::getMvcInstance()->assign('user', $sesion_usuario->sesion_usuario['nombre_completo']);
        
    }
}