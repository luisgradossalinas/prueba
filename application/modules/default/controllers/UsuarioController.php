<?php

class Default_UsuarioController extends Zend_Controller_Action
{

    private $_formUsuario;
    
    public function init()
    {
        $this->_formUsuario = new Application_Form_Usuario;
    }

    public function indexAction()
    {
        // action body
    }

    public function formAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        echo $this->_formUsuario;
    }


}



