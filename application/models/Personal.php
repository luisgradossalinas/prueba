<?php

class Application_Model_Personal extends Zend_Db_Table
{

    protected $_name = 'personal';

    protected $_primary = 'id_personal';

    const ESTADO_INACTIVO = 0;

    const ESTADO_ACTIVO = 1;

    const ESTADO_ELIMINADO = 2;

    const TABLA = 'personal';

    public function guardar($datos)
    {
        $id = 0;
        if (!empty($datos['id_personal'])) {
        	$id = (int) $datos['id_personal'];
        }
        
        unset($datos['id_personal']);
        $datos = array_intersect_key($datos, array_flip($this->_getCols()));
        
        if ($id > 0) {
        	$cantidad = $this->update($datos, 'id_personal = ' . $id);
        	$id = ($cantidad < 1) ? 0 : $id;
        } else {
        	$id = $this->insert($datos);
        }
        
        return $id;
    }

    public function listado()
    {
        return $this->fetchAll();
    }


}

