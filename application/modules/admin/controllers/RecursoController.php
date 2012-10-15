<?php

class Admin_RecursoController extends App_Controller_Action_Admin
{
    
    const INACTIVO = 0;
    const ACTIVO = 1;
    const ELIMINADO = 2;
    
    public function init()
    {
        parent::init();
    }
    
    public function listadoAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $data = $this->_getAllParams();

        //Previene vulnerabilidad XSS (Cross-site scripting)
        $filtro = new Zend_Filter_StripTags();
        foreach ($data as $key => $val) {
            $data[$key] = $filtro->filter(trim($val));
        }

        
        if ($this->_getParam('ajax') == 'listado') {
            if ($this->_hasParam('id_rol')) {
                $recurso = new Application_Model_Recurso;
                $listadoRecursos = $recurso->fetchAll('estado ='. self::ACTIVO)->toArray();
                echo Zend_Json::encode($listadoRecursos);
                
            }
        }

    }
    

}



