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
        
        
    }
    
    public function indexAction()
    {
        $table = new Application_Model_Generator();
     //   $col = count($table->columnas('distrito'));
        
     //   print_r($table->columnas('distrito'));
        print_r($table->listaTablas());
        
     //   echo $col;
        echo $this->_form; 
      
    }
 

}



