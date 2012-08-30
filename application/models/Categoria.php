<?php

class Application_Model_Categoria extends Zend_Db_Table
{
    protected $_name = 'categoria';
    
    const INACTIVA = 0;
    const ACTIVA = 1;
    const ELIMINADO = 2;
    
    public function combo()
    {
        return $this->getAdapter()->select()->from($this->_name,array('key' => 'id', 'value' => 'nom_cat'))
                ->where('estado = ?',self::ACTIVA)->query()->fetchAll();
    }
    
    public function guardar($datos)
    {         
        $id = 0;
        if (!empty($datos['id'])) {
            $id = (int) $datos['id'];
        }
        unset($datos['id']);

        $datos = array_intersect_key($datos, array_flip($this->_getCols()));

        foreach ($datos as $key => $valor) {
            if (!is_numeric($valor)) {
                $datos[$key] = str_replace("'", '"', $valor);
            }
        }

        if ($id > 0) {
            $cantidad = $this->update($datos, 'id = ' . $id);
            $id = ($cantidad < 1) ? 0 : $id;
        } else {
            $id = $this->insert($datos);
        }
        return $id;
    }


}

