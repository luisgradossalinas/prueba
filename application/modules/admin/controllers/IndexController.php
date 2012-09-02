<?php

class Admin_IndexController extends App_Controller_Action_Admin
{
    private $_usuarioModel = null;
    private $_productoModel = null;
    private $_categoriaModel = null;

    public function init()
    {
        parent::init();
        $this->_usuarioModel = new Application_Model_Usuario;
        $this->_productoModel = new Application_Model_Producto;
        $this->_categoriaModel = new Application_Model_Categoria;
    }

    public function indexAction()
    {
        
    }

    public function usuarioAction()
    {
        Zend_Layout::getMvcInstance()->assign('active','usuarios');
        $this->view->headLink()->appendStylesheet(SITE_URL.'/jquery/css/dataTables.css', 'all');
        $this->view->headScript()->appendFile(SITE_URL.'/jquery/plugins/jquery.dataTables.js');
        $this->view->headScript()->appendFile(SITE_URL.'/assets/js/bootstrap-dataTable.js');
        $this->view->headScript()->appendFile(SITE_URL.'/assets/web/usuario.js');
        $data = $this->_usuarioModel->fetchAll();
        $this->view->usuario = $data;
    }

    public function productoAction()
    {
        Zend_Layout::getMvcInstance()->assign('active','productos');
        $this->view->headLink()->appendStylesheet(SITE_URL.'/jquery/css/dataTables.css', 'all');
        $this->view->headScript()->appendFile(SITE_URL.'/jquery/plugins/jquery.dataTables.js');
        $this->view->headScript()->appendFile(SITE_URL.'/assets/js/bootstrap-dataTable.js');
        $this->view->headScript()->appendFile(SITE_URL.'/assets/web/producto.js');
        $data = $this->_productoModel->fetchAll();
        $this->view->producto = $data;
    }
    
    public function categoriaAction()
    {
        Zend_Layout::getMvcInstance()->assign('active','categorias');
        $this->view->headLink()->appendStylesheet(SITE_URL.'/jquery/css/dataTables.css', 'all');
        $this->view->headScript()->appendFile(SITE_URL.'/jquery/plugins/jquery.dataTables.js');
        $this->view->headScript()->appendFile(SITE_URL.'/assets/js/bootstrap-dataTable.js');
        $this->view->headScript()->appendFile(SITE_URL.'/assets/web/categoria.js');
        $data = $this->_categoriaModel->fetchAll('estado != '.Application_Model_Categoria::ELIMINADO);
        $this->view->categoria = $data;
    }


}





