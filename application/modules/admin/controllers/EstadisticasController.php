<?php

class Admin_EstadisticasController extends App_Controller_Action_Admin
{
    
    const INACTIVO = 0;
    const ACTIVO = 1;
    const ELIMINADO = 2;
    
    private $_rolrecurso;
    private $_recurso;
    
    public function init()
    {
        parent::init();
        
    }
    
    public function usuarioAction() 
    {
        Zend_Layout::getMvcInstance()->assign('active', 'estusuarios');
        Zend_Layout::getMvcInstance()->assign('padre', '6');
        Zend_Layout::getMvcInstance()->assign('link', 'estusuarios');
        echo "hola";
    }
    
    public function productoAction() 
    {
        Zend_Layout::getMvcInstance()->assign('active', 'estproductos');
        Zend_Layout::getMvcInstance()->assign('padre', '6');
        Zend_Layout::getMvcInstance()->assign('link', 'estproductos');
        echo "hola";
    }
    

}



