<?php

class Application_Model_Docente extends Zend_Db_Table
{

    protected $_name = 'docente';

    protected $_primary = 'id';

    const ESTADO_INACTIVO = 0;

    const ESTADO_ACTIVO = 1;

    const ESTADO_ELIMINADO = 2;

    const TABLA = 'docente';

    public function guardar($datos)
    {
        $id = 0;
        if (!empty($datos["id"])) {
        	$id = (int) $datos["id"];
        }
        
        unset($datos["id"]);
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));
        
        if ($id > 0) {
            if (isset($datos['fecha_nac']) && !empty($datos['fecha_nac'])) {
        	$datos['fecha_nac'] = new Zend_Date($datos['fecha_nac'],'yyyy-mm-dd');
        	$datos['fecha_nac'] = $datos['fecha_nac']->get('yyyy-mm-dd');
            }
            if (isset($datos['fecha_registro']) && !empty($datos['fecha_registro'])) {
        	$datos['fecha_registro'] = new Zend_Date($datos['fecha_registro'],'yyyy-mm-dd');
        	$datos['fecha_registro'] = $datos['fecha_registro']->get('yyyy-mm-dd');
            }
        	$cantidad = $this->update($datos, 'id = ' . $id);
        	$id = ($cantidad < 1) ? 0 : $id;
        } else {
            if (isset($datos['fecha_nac']) && !empty($datos['fecha_nac'])) {
        	$datos['fecha_nac'] = new Zend_Date($datos['fecha_nac'],'yyyy-mm-dd');
        	$datos['fecha_nac'] = $datos['fecha_nac']->get('yyyy-mm-dd');
            }
            if (isset($datos['fecha_registro']) && !empty($datos['fecha_registro'])) {
        	$datos['fecha_registro'] = new Zend_Date($datos['fecha_registro'],'yyyy-mm-dd');
        	$datos['fecha_registro'] = $datos['fecha_registro']->get('yyyy-mm-dd');
            }
        	$id = $this->insert($datos);
        }
        
        return $id;
    }

    public function listado()
    {
        return $this->getAdapter()->select()->from($this->_name)->query()->fetchAll();
    }


}

