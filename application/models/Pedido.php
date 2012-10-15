<?php

class Application_Model_Pedido extends Zend_Db_Table
{
    protected $_name = 'pedido';
    protected $_primary = 'id';
        
    const ESTADO_INACTIVO = 0;
    const ESTADO_ACTIVO = 1;
    const ESTADO_ELIMINADO = 2;
    
    const TABLA = 'pedido';
    
    public function guardar($datos)
    {         
        $id = 0;
        if (!empty($datos['id'])) {
            $id = (int) $datos['id'];
        }
        unset($datos['id']);

        $datos = array_intersect_key($datos, array_flip($this->_getCols()));

        if ($id > 0) {
            $cantidad = $this->update($datos, 'id = ' . $id);
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            $id = $this->insert($datos);
        }
        return $id;
    }
    
    public function listado() {
        
        return $this->getAdapter()->select()->from(
                array('a' => $this->_name), 
                array(
                    'id', 'id_usuario', 'nombres' => 'concat(b.nombres," ",b.apellidos)', 'entregado',
                        'fecha_genera', 'fecha_entrega'
                ))
                ->joinInner(
                    array('b' => Application_Model_Usuario::TABLA), 'a.id_usuario = b.id', null)
                ->query()->fetchAll();
    }


}

