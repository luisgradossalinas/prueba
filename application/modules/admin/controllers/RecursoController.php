<?php

class Admin_RecursoController extends App_Controller_Action_Admin
{
    
    const INACTIVO = 0;
    const ACTIVO = 1;
    const ELIMINADO = 2;
    
    private $_rolrecurso;
    
    public function init()
    {
        parent::init();
        
        $this->_rolrecurso = new Application_Model_RolRecurso;
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
                $rol = $this->_getParam('id_rol');
                $recurso = new Application_Model_Recurso;
                //$listadoRecursos = $recurso->fetchAll('estado ='. self::ACTIVO)->toArray();
                $listadoRecursos = $recurso->listadoPorRol($rol);
                echo Zend_Json::encode($listadoRecursos);
                
            }
        }

    }
    
    public function agregarRecursosAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        if (!$this->getRequest()->isXmlHttpRequest())
            exit('Acción solo válida para peticiones ajax');
        
        $rol = $this->_getParam('rol');
        $recursoADD = $this->_getParam('rec_add');
        $recursoDEL = substr($this->_getParam('rec_del'), 0, -1);
        $rolrecurso =  new Application_Model_RolRecurso;
        
        if (!empty($recursoDEL))
        $rolrecurso->delete('id_rol = '.$rol.' and id_recurso in ('.$recursoDEL.')');
        
        if (count($recursoADD) > 0) {
            foreach ($recursoADD as $reg){
                //verifica si el recurso está asignado al rol
                $dataRR = $rolrecurso->fetchAll('id_rol = '.$rol. ' and id_recurso = '.$reg);
                if (count($dataRR) == 0)
                    $rolrecurso->insert(array('id_rol' => $rol,'id_recurso' => $reg));
            }
        }
        
    }
    

}



