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
        $this->_helper->layout->setLayout("admin");

        $sesion_usuario = new Zend_Session_Namespace('sesion_usuario');

        $this->view->active = 'Recursos para el usuario 
            ' . $sesion_usuario->sesion_usuario['nombre_completo'].
                " (".$sesion_usuario->sesion_usuario['nombre_rol'].")";

        $id = $sesion_usuario->sesion_usuario['id'];
        $this->view->data = $this->_usuarioModel->recursosPorUsuario($id);
        Zend_Layout::getMvcInstance()->assign('btnNuevo','0');
    }
        public function plantillaAction()
    {
        $this->_helper->setLayout('plantilla');
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
    
    public function changeCssAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->getConfig()->app->estiloCss = $this->_getParam('color');
        }
        echo $this->getConfig()->app->estiloCss;
        /*
        $config = Zend_Registry::get('config');
        $config->app->estiloCss = $this->_getParam('estilo');
        //echo ESTILO_CSS;
        //echo $config->app->estiloCss;exit;
        //!defined('SITE_URL')? define('SITE_URL', $config->app->siteUrl):null; 
        //echo ESTILO_CSS;exit;
        $this->_redirect(SITE_URL);*/
    }
    
    public function testAction() {
        
        
        echo "hola";
        
    }


}





