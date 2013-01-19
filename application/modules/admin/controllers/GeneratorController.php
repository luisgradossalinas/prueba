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
        
        
     /*   $file = new Zend_CodeGenerator_Php_File(array(
        'classes' => array(
            new Zend_CodeGenerator_Php_Class(array(
                'name'    => 'Tabla extends Hola',
                'methods' => array(
                    new Zend_CodeGenerator_Php_Method(array(
                        'name' => 'hello',
                        'body' => 'echo \'Hello world!\';',
                    )),
                ),
            )),
        )
    ));*/
 
        // Configuring after instantiation
        $method = new Zend_CodeGenerator_Php_Method();
        $method->setName('hola')
               ->setBody('echo \'Hello world!\';');

        $class = new Zend_CodeGenerator_Php_Class();
        $class->setName('Formulario extends Hola')
              ->setMethod($method);

        $file = new Zend_CodeGenerator_Php_File();
        $file->setClass($class);

        // Render the generated file
        echo $file;

        // or write it to a file:
        file_put_contents(APPLICATION_PATH.'/forms/Formulario.php', $file->generate());
      
    }
 

}



