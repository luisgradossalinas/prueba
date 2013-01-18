<?php

class Admin_GeneratorController extends App_Controller_Action_Admin
{
    private $_model;
    private $_form;
    private $_clase;
    
    private $_recurso;
    
    const INACTIVO = 0;
    const ACTIVO = 1;
    const ELIMINADO = 2;
    
    public function init()
    {
        parent::init();
        $this->_form = new Application_Form_Generator;
        $this->_helper->layout->setLayout('generator');
        
    }
    
    public function indexAction()
    {
        
       // $table = new Application_Model_Generator();
     //   $col = count($table->columnas('distrito'));
        
     //   print_r($table->columnas('distrito'));
       // print_r($table->listaTablas());
        
     //   echo $col;
        $this->view->headScript()->appendFile(SITE_URL.'/js/generator/config.js');
        
        $this->view->active = 'Generator de CRUD';
        Zend_Layout::getMvcInstance()->assign('link', 'generator');
        Zend_Layout::getMvcInstance()->assign('active', 'generator');
        Zend_Layout::getMvcInstance()->assign('padre', '5');
        
        $this->view->form = $this->_form; 
      
    }
 

}



