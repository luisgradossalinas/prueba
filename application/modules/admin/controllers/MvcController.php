<?php

class Admin_MvcController extends App_Controller_Action_Admin
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
        
        $sesionMvc  = new Zend_Session_Namespace('sesion_mvc');
        $this->_recurso = new Application_Model_Recurso;
        
        if ($this->_getParam('model')) {
            
            $this->_model = $this->_getParam('model');
            $form = 'Application_Form_'.ucfirst($this->_model);
            $clase = 'Application_Model_'.ucfirst($this->_model);
            $sesionMvc->form = $form;
            $sesionMvc->clase = $clase;
        
        }
        
        $this->_form = new $sesionMvc->form;
        $this->_clase = new $sesionMvc->clase;
        
    }
    
    public function indexAction()
    {   
        $idPadre = $this->_recurso->obtenerPadre($this->_model);
        
        Zend_Layout::getMvcInstance()->assign('link', $this->_model);
        Zend_Layout::getMvcInstance()->assign('active', ucfirst($this->_model).'s');
        Zend_Layout::getMvcInstance()->assign('padre', $idPadre);
        
        $this->view->headScript()->appendFile(SITE_URL.'/js/web/mvc.js');
        $this->view->data = $this->_clase->fetchAll('estado != '.self::ELIMINADO);
        $this->view->model = ucfirst($this->_model);
        $this->view->active = ucfirst($this->_model).'s';
        $this->render($this->_model);
    }
    
    public function operacionAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $data = $this->_getAllParams();

        //Previene vulnerabilidad XSS (Cross-site scripting)
        $filtro = new Zend_Filter_StripTags();
        foreach ($data as $key => $val) {
            $data[$key] = $filtro->filter(trim($val));
        }
        
        //Muestra formulario vacío (Nuevo) o con data según petición ajax (Editar)
        if ($this->_getParam('ajax') == 'form') {
            
            if ($this->_hasParam('id')) {
                $id = $this->_getParam('id');
                if ($id != 0) {
                    $data = $this->_clase->fetchRow('id = '.$id);
                    $this->_form->populate($data->toArray());
                }
            }
            echo $this->_form;         
        }
        
        //Validación de formulario
        if ($this->_getParam('ajax') == 'validar') {
                echo $this->_form->processAjax($data);
        }
        
        //Eliminación de registro
        if ($this->_getParam('ajax') == 'delete') {
            $where = $this->getAdapter()->quoteInto('id = ?',$data['id']);
            $this->_clase->update(array('estado' => self::ELIMINADO),$where);
        }
   
        // Grabar
        if ($this->_getParam('ajax') == 'save') {
            //$data['fecha_crea'] = date("Y-m-d H:i:s");
            //$data['usuario_crea'] = Zend_Auth::getInstance()->getIdentity()->id;
            $this->_clase->guardar($data);
        }
    }
    

}



