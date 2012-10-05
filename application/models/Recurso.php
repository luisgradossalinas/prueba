<?php

class Application_Model_Recurso extends Zend_Db_Table
{
    protected $_name = 'recurso';
    protected $_primary = 'id';

    const TABLA = 'recurso';

    const ESTADO_INACTIVO = 0;
    const ESTADO_ACTIVO = 1;
    const ESTADO_ELIMINADO = 2;
    
    const PADRE = 1;
      
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
    
    //Para generar el menú dinámico 
    public function recursoByRol ($rol)
    {
        return $this->_db->select()->from(array("a" => $this->_name))
                ->joinInner(array("b" => "rol_recurso"), "b.id_recurso = a.id",null)
                ->where("b.id_rol = ?",$rol)->where("estado = ?",self::ESTADO_ACTIVO)->where("orden  != ?",self::PADRE)
                ->order(array('a.padre asc','a.orden asc'))->query()->fetchAll();
    }
   
    //Para generar el menú a SUṔER
    public function listaRecursosSuper ()
    {
        return $this->_db->select()->distinct()->from(array("a" => $this->_name))
                ->where("estado = ?",self::ESTADO_ACTIVO)->where("orden  != ?",self::PADRE)
                ->order(array('a.padre asc','a.orden asc'))->query()->fetchAll();
    }
    
    //Generación de menú
    public function generacionMenu()
    {
         $auth = Zend_Auth::getInstance();
         $rol = $auth->getIdentity()->id_rol;
         $dataRecursos = $this->recursoByRol($rol);
         $menu = "";
         //Ver cuantos padre hay
         if ($rol == Application_Model_Rol::SUPER) {
             $dataRecursos = $this->listaRecursosSuper();
         }

         $nReg = count($dataRecursos);
         $arrayPadre = array();
         if ($nReg > 0) {
             for ($i = 0;$i < $nReg; $i++) {
                 $arrayPadre[] = $dataRecursos[$i]["padre"];
             }
         }
         $dataSub = array_count_values($arrayPadre);
         $arrayPadre = array_unique($arrayPadre);

         $arraySubMenu = array();
         foreach ($dataSub as $sub) {
             $arraySubMenu[] = $sub;
         }

         $arrayPadreSubMenu = array();
         foreach ($arrayPadre as $padre) {
             $arrayPadreSubMenu[] = $padre;
         }

         $menu .= '<ul id="qm0" class="qmmc">';
         $contador = 0;
         
         for ($x = 0; $x < count($arrayPadre);$x++) {
             
             $dataPadre = $this->obtenerRecursoPadre($arrayPadreSubMenu[$x]);
             $menu .= "<li><a>".$dataPadre["nombre"]."</a><ul>";
             
             for ($d = 0;$d < $arraySubMenu[$x]; $d++) {
                 
                 $tab = $dataRecursos[$contador]["tab"];
                 $nombre = $dataRecursos[$contador]["nombre"];
                 $url = $dataRecursos[$contador]["url"];
                 $menu .= "<li><a href ='javascript:agregarTab(".'"'. $tab.'"'.",".'"'. $nombre.'"'.",".'"'. $url.'"'.")'";
                 $menu .= ">".$nombre."</a></li>";
                 $contador++;
                 
             }
             
             $menu .= "</ul></li>";
             
         }

         return array("menu" => $menu,"registro" => $nReg);
    }
    
    


}

