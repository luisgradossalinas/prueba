<?php

class Admin_UsuarioController extends Zend_Controller_Action
{

    private $_formUsuario;
    private $_usuarioModel;
    
    public function init()
    {
        $this->_formUsuario = new Application_Form_Usuario;
        $this->_usuarioModel = new Application_Model_Usuario;
    }

    public function indexAction()
    {
        Zend_Layout::getMvcInstance()->assign('active','usuarios');
        $this->view->headLink()->appendStylesheet(SITE_URL.'/jquery/css/dataTables.css', 'all');
        $this->view->headScript()->appendFile(SITE_URL.'/jquery/plugins/jquery.dataTables.js');
        $this->view->headScript()->appendFile(SITE_URL.'/assets/js/bootstrap-dataTable.js');
        $this->view->headScript()->appendFile(SITE_URL.'/assets/web/usuario.js');
        $data = $this->_usuarioModel->fetchAll();
        $this->view->usuario = $data;
    }

    public function formAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        echo $this->_formUsuario;
    }


}



