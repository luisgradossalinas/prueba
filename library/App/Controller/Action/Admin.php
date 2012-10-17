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
        $configuracion = new Application_Model_Configuracion;
        $estiloPanel = $configuracion->fetchRow('nombre = "'. Application_Model_Configuracion::ESTILO_PANEL.'"');
        
        $color = 'grey';
        
        if(in_array($estiloPanel['valor'], Application_Model_Configuracion::$_ARRAY_ESTILO_PANEL)) {
            $color = $estiloPanel['valor'];
        }
        
        Zend_Layout::getMvcInstance()->assign('user', $sesion_usuario->sesion_usuario['nombre_completo']);
        Zend_Layout::getMvcInstance()->assign('css', $color);
        
    }
}