<?php

class Admin_GeneratorController extends App_Controller_Action_Admin
{
    
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
        
        $this->view->headScript()->appendFile(SITE_URL.'/js/generator/config.js');
        
        $this->view->active = 'Generator de CRUD';
        Zend_Layout::getMvcInstance()->assign('link', 'generator');
        Zend_Layout::getMvcInstance()->assign('active', 'generator');
        Zend_Layout::getMvcInstance()->assign('padre', '5');
        
        $this->view->form = $this->_form;        
      
    }
    
    public function generarCodeAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
       
        if (!$this->getRequest()->isXmlHttpRequest())
            exit('Acción solo válida para peticiones ajax');
        
        $tabla = $this->_getParam('tabla');
        $formulario = ucfirst($tabla);
        
        $generator = new Generator_Form();
        
        $formMetodo = new Zend_CodeGenerator_Php_Method();
        $formMetodo->setName('init')
               ->setBody(
                    $generator->cuerpoFormulario($tabla)
                );

        $formClase = new Zend_CodeGenerator_Php_Class();
        $formClase->setName('Application_Form_'.$formulario.' extends Zend_Form')
              ->setMethod($formMetodo);

        //Creación de atributos
      /*  $class->setProperties(array(
        array(
            'name'         => '_bar',
            'visibility'   => 'protected',
            'defaultValue' => 'baz',
        ),
        array(
            'name'         => 'baz',
            'visibility'   => 'public',
            'defaultValue' => 'bat',
        ),
        array(
            'name'         => 'bat',
            'const'        => true,
            'defaultValue' => 'foobarbazbat1',
        ),
    ));*/
        
        $formArchivo = new Zend_CodeGenerator_Php_File();
        $formArchivo->setClass($formClase);
        
        //Donde guardar los archivos
        $rutaFormulario = APPLICATION_PATH.'/forms/'.$formulario.'.php';
        file_put_contents($rutaFormulario, $formArchivo->generate());
        chmod($rutaFormulario, 0777);
        
        echo "Formulario generado correctamente.";
    }
 

}



