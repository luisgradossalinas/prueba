<?php
/**
 * Description of Util
 * 
 * @author eanaya
 *
 */
class App_Controller_Action_Helper_LogActualizacionBI extends Zend_Controller_Action_Helper_Abstract
{

    public function __construct()
    {
        $this->_config = Zend_Registry::get('config');
    }
    /**
     * 
     * Registra un log de las actualizacion por elemento que hace el cliente de registro de datos paso1
     * @param int $idPostulante
     * @param array $valuesPost
     */
    public function logActualizacionPostulantePaso1($idPostulante, $valuesPost)
    {
        $modelLogPostulante = new Application_Model_LogPostulante();
        $modelPostulante = new Application_Model_Postulante();
        
        $date = date('Y-m-d H:i:s');
        $arrayLogPostulante = $modelLogPostulante->getLogPostulanteDatosPaso1($idPostulante);
        $arrayPostulante = $modelPostulante->getPostulante($idPostulante);

        $data = array(
            'id_postulante' => $idPostulante,
            'fh_creacion' => $date,
            'fh_actualizacion' => $date,
        );
        
        //@codingStandardsIgnoreStart  
        $tipoElemento = array (
           Application_Model_LogPostulante::DATOS_PERSONALES,
           Application_Model_LogPostulante::WEB ,
           Application_Model_LogPostulante::PRESENTACION ,
           Application_Model_LogPostulante::FOTO 
        );
        //@codingStandardsIgnoreEnd 
         
        $codicionElemento = array(
            0 == 0,
            isset($valuesPost["website"]) && $arrayPostulante["website"] != $valuesPost["website"],
            isset($valuesPost["presentacion"]) && $arrayPostulante["presentacion"] != $valuesPost["presentacion"],
             $arrayPostulante["path_foto"] != $valuesPost["path_foto"] && $valuesPost["path_foto"] != ''
        );
        
        $codicionElementoDelete = array(
            0 != 0,
            !isset($valuesPost["website"]) && $valuesPost["website"] == null ,
            !isset($valuesPost["presentacion"]) && $valuesPost["presentacion"] == null,
            $valuesPost["path_foto"] == ''
        );
        
        $porcentajeElemento = array (
            0,
            $this->_config->dashboard->peso->tuweb,
            $this->_config->dashboard->peso->presentacion,
            $this->_config->dashboard->peso->foto,
        );
        
        if (count($arrayLogPostulante)!= 0) {
            $count = 0;
            $maxTipoEle = count($tipoElemento);
            foreach ($arrayLogPostulante as $row) {
                $where = $modelLogPostulante->getAdapter()->quoteInto('id = ?', $row['id']);
                $count = 0;
                for ($a = $count ; $a < $maxTipoEle; $a++) {
                    if ( isset($tipoElemento[$a]) && $row['campo_modificado'] == $tipoElemento[$a] ) {
                        unset($tipoElemento[$a]);
                        if ($codicionElemento[$a]) {
                            $modelLogPostulante->update(array('fh_actualizacion' => $date ), $where);
                        } elseif ($codicionElementoDelete[$a]) {
                            $modelLogPostulante->delete($where);
                        }
                    }
                }
            }
            
            $maxTipoElemento = count($tipoElemento);
            for ($a = 1; $a < $maxTipoEle; $a++) {
                $condicion = $codicionElemento[$a];
                if ($condicion && isset($tipoElemento[$a])) {
                    $data['campo_modificado'] = $tipoElemento[$a];
                    $data['porcentaje'] = $porcentajeElemento[$a] ;
                    $modelLogPostulante->insert($data);
                }
            }
            
        } else {
            
            $data['campo_modificado'] = $tipoElemento[0];
            $data['porcentaje'] = $porcentajeElemento[0];
            
            $modelLogPostulante->insert($data);
            
            if ( isset($valuesPost['website']) && $valuesPost['website'] != null) {
                
                $data['campo_modificado'] = $tipoElemento[1];
                $data['porcentaje'] = $porcentajeElemento[1];
                $modelLogPostulante->insert($data);
            }
            
            if ( isset($valuesPost['presentacion']) && $valuesPost['presentacion'] != null) {
                
                $data['campo_modificado'] = $tipoElemento[2];
                $data['porcentaje'] = $porcentajeElemento[2];
                $modelLogPostulante->insert($data);
            }
            
            if ($valuesPost['path_foto'] != '') {
                
                $data['campo_modificado'] = $tipoElemento[3];
                $data['porcentaje'] = $porcentajeElemento[3];
                $modelLogPostulante->insert($data);
            }
        }
        
        $this->actualizarAcumulado($idPostulante);
    }
    
    public function logActualizacionPostulantePaso2 (
        $idPostulante, $campoModificar = null, $valOriCv = null, $valNueCv = null
    )
    {
        if (isset($campoModificar)) {
            $modelLog = new Application_Model_LogPostulante();
            $idLog = $modelLog->getLogPostulanteDatosPaso2($idPostulante, $campoModificar);
            $date = date('Y-m-d H:i:s');
            $data = array(
                'id_postulante' => $idPostulante,
                'fh_creacion' => $date,
                'fh_actualizacion' => $date,
                'campo_modificado' => $campoModificar,
            );
            $dataUpdate = array ('fh_actualizacion' => $date ); 
        }
        //var_dump($campoModificar);
        //var_dump($idLog);
        
            
        if ($campoModificar == Application_Model_LogPostulante::ESTUDIOS) {
            $modelEstudio = new Application_Model_Estudio();
            $arrayEstudio = $modelEstudio->getEstudios($idPostulante);
//            var_dump(count($arrayEstudio));
//            echo '<br>';
            $where = $modelLog->getAdapter()->quoteInto('id = ?', $idLog);
            
            if (count($arrayEstudio) >= 1 && $idLog != false) {
//                echo 'Estudio Update';
                $modelLog->update($dataUpdate, $where);
                //update
            } elseif (count($arrayEstudio) > 1 && $idLog == false) {
//                echo 'Estudio insert 1';
                $data['porcentaje'] = $this->_config->dashboard->peso->estudios;
                $modelLog->insert($data);
                //insert
            } elseif (count($arrayEstudio) == 1 && $idLog == false) {
//                echo 'Estudio insert 2';
                $data['porcentaje'] = $this->_config->dashboard->peso->estudios;
                $modelLog->insert($data);
                //insert
            } elseif (count($arrayEstudio) == 0 && $idLog != false) {
                //echo 'Estudio delete';
                $modelLog->delete($where);
                //delete
            }
        } elseif ($campoModificar == Application_Model_LogPostulante::EXPERIENCIA) {
        
            $modelExperiencia = new Application_Model_Experiencia();
            $arrayExperiencia = $modelExperiencia->getExperiencias($idPostulante);
            //var_dump(count($arrayExperiencia));
            //echo '<br>';
            $where = $modelLog->getAdapter()->quoteInto('id = ?', $idLog);
            
            if (count($arrayExperiencia) >= 1 && $idLog != false) {
                //echo 'Experiencia Update';
                $modelLog->update($dataUpdate, $where);
                //update
            } elseif (count($arrayExperiencia) > 1 && $idLog == false) {
                //echo 'Experiencia insert 1';
                $data['porcentaje'] = $this->_config->dashboard->peso->experiencia;
                $modelLog->insert($data);
                //insert
            } elseif (count($arrayExperiencia) == 1 && $idLog == false) {
                //echo 'Experiencia insert 2';
                $data['porcentaje'] = $this->_config->dashboard->peso->experiencia;
                $modelLog->insert($data);
                //insert
            } elseif (count($arrayExperiencia) == 0 && $idLog != false) {
                //echo 'Experiencia delete';
                $modelLog->delete($where);
                //delete
            }
        } elseif ($campoModificar == Application_Model_LogPostulante::IDIOMAS) {
            $modelIdioma = new Application_Model_DominioIdioma();
            $arrayIdioma = $modelIdioma->getDominioIdioma($idPostulante);
            //var_dump(count($arrayIdioma));
            //echo '<br>';
            $where = $modelLog->getAdapter()->quoteInto('id = ?', $idLog);
            
            if (count($arrayIdioma) >= 1 && $idLog != false) {
                //echo 'Idioma Update';
                $modelLog->update($dataUpdate, $where);
                //update
            } elseif (count($arrayIdioma) > 1 && $idLog == false) {
                //echo 'Idioma insert 1';
                $data['porcentaje'] = $this->_config->dashboard->peso->idiomas;
                $modelLog->insert($data);
                //insert
            } elseif (count($arrayIdioma) == 1 && $idLog == false) {
                //echo 'Idioma insert 2';
                $data['porcentaje'] = $this->_config->dashboard->peso->idiomas;
                $modelLog->insert($data);
                //insert
            } elseif (count($arrayIdioma) == 0 && $idLog != false) {
                //echo 'Idioma delete';
                $modelLog->delete($where);
                //delete
            }
        } elseif ($campoModificar == Application_Model_LogPostulante::PROGRAMAS) {
            $modelPrograma = new Application_Model_DominioProgramaComputo();
            $arrayPrograma = $modelPrograma->getDominioProgramaComputo($idPostulante);
            //var_dump(count($arrayPrograma));
            //echo '<br>';
            $where = $modelLog->getAdapter()->quoteInto('id = ?', $idLog);
            
            if (count($arrayPrograma) >= 1 && $idLog != false) {
                //echo 'Progamas update';
                $modelLog->update($dataUpdate, $where);
                //update
            } elseif (count($arrayPrograma) > 1 && $idLog == false) {
                //echo 'Progamas insert 1';
                $data['porcentaje'] = $this->_config->dashboard->peso->programas;
                $modelLog->insert($data);
                //insert
            } elseif (count($arrayPrograma) == 1 && $idLog == false) {
                //echo 'Progamas insert 2';
                $data['porcentaje'] = $this->_config->dashboard->peso->programas;
                $modelLog->insert($data);
                //insert
            } elseif (count($arrayPrograma) == 0 && $idLog != false) {
                //echo 'Progamas delete';
                $modelLog->delete($where);
                //delete
            }
        } elseif ($campoModificar == Application_Model_LogPostulante::SUBIR_CV) {
            
            $where = $modelLog->getAdapter()->quoteInto('id = ?', $idLog);
            
            if ($valOriCv != $valNueCv && $valNueCv != '' && $idLog != false) {
                //echo 'cv update';
                $modelLog->update($dataUpdate, $where);
                //update
            } elseif ($valNueCv != '' && $valOriCv != $valNueCv && $idLog == false) {
                //echo 'cv insert';
                $data['porcentaje'] = $this->_config->dashboard->peso->subircv;
                $modelLog->insert($data);
                //insert
            } elseif ($valNueCv == '' && $valNueCv != $valOriCv && $idLog != false) {
                //echo 'cv delete';
                $modelLog->delete($where);
                //delete
            }
        }//exit;
        
        $this->actualizarAcumulado($idPostulante);
        
    }
    
    public function logActualizacionEmpresaLogeo($valuesPost)
    {
        
        $data = array (
            'id_empresa' => $valuesPost['id_empresa'],
            'id_usuario' => $valuesPost['id_usuario'],
            'fh_login' => date('Y-m-d H:i:s')
        );
        
        $modelLogEmpresa = new Application_Model_LogEmpresa();
        $modelLogEmpresa->insert($data);
    }
    
    public function logActualizacionBuscadorAviso($params, $idEmpresa, $idTipoBusqueda)
    {
        $parametros = $this->_config->buscadorempresa->param;
         
        $data = array (
            'id_empresa' => $idEmpresa,
            'tipo_busqueda' => $idTipoBusqueda
        );
        
        if (isset($params['tipo'])) {
            if (isset($params['niveldeestudios']) && $params['niveldeestudios'] != '' 
                && $parametros->nivelestudios == $params['tipo']) {
                //echo 'Nivel Estudio';
                
                $data['tipo_filtro'] = $parametros->nivelestudios;
                $this->mantenimientoBusqueda($data, $params['niveldeestudios']);
            } 
            
            if (isset($params['tipodecarrera']) && $params['tipodecarrera'] != '' 
                && $parametros->tipodecarrera == $params['tipo']) {
                //echo 'Nivel Carrera';
                
                $data['tipo_filtro'] = $parametros->tipodecarrera;
                $this->mantenimientoBusqueda($data, $params['tipodecarrera']);
            } 
            
            if (isset($params['experiencia']) && $params['experiencia'] != '' 
                && $parametros->experiencia == $params['tipo']) {
                //echo 'Nivel Experiencia';
                
                $data['tipo_filtro'] = $parametros->experiencia;
                $this->mantenimientoBusqueda($data, $params['experiencia']);
            } 
            
            if (isset($params['idiomas']) && $params['idiomas'] != '' 
                && $parametros->idiomas == $params['tipo']) {
                //echo 'Nivel Idioma';
                
                $data['tipo_filtro'] = $parametros->idiomas;
                $this->mantenimientoBusqueda($data, $params['idiomas']);
            } 
            
            if (isset($params['programas']) && $params['programas'] != '' 
                && $parametros->programas == $params['tipo']) {
                //echo 'Nivel Programa';
                
                $data['tipo_filtro'] = $parametros->programas;
                $this->mantenimientoBusqueda($data, $params['programas']);
            } 
            
            if (isset($params['edad']) && $params['edad'] != '' 
                && $parametros->edad == $params['tipo']) {
                //echo 'Nivel Edad';
                
                $data['tipo_filtro'] = $parametros->edad;
                $this->mantenimientoBusqueda($data, $params['edad']);
            } 
            
            if (isset($params['sexo']) && $params['sexo'] != '' 
                && $parametros->sexo == $params['tipo']) {
                //echo 'Nivel Ubicacion';
                
                $data['tipo_filtro'] = $parametros->sexo;
                $this->mantenimientoBusqueda($data, $params['sexo']);
            }
            
            if (isset($params['ubicacion']) && $params['ubicacion'] != '' 
                && $parametros->ubicacion == $params['tipo']) {
                //echo 'Nivel Ubicacion';
                
                $data['tipo_filtro'] = $parametros->ubicacion;
                $this->mantenimientoBusqueda($data, $params['ubicacion']);
            }
            
            if (isset($params['query']) && $params['query'] != '' 
                && $parametros->query == $params['tipo']) {
                //echo 'Nivel Query';
                
                $data['tipo_filtro'] = $parametros->query;
                $this->mantenimientoBusqueda($data, null);
                
            }
        }
    }
    
    public function mantenimientoBusqueda ($data, $valueFiltro)
    {
        
        $modelLogBusqueda = new Application_Model_LogBusqueda;
        $date = date('Y-m-d H:i:s');
        
        $niveldeestudios = $valueFiltro;
        $arrayRow = explode("--", $niveldeestudios);
        $count = count($arrayRow);

        for ($i = $count-1; $i < $count; $i++) {
            $data['tipo_opcion_id'] = $arrayRow[$i];
            $arrayLogBusqueda = $modelLogBusqueda->getLogBusquedaXIdEmpresa($data);
            unset($data['tipo_opcion_id']);
        }
        
        if ($arrayLogBusqueda == false) {
            //echo '1º insert';
            $data['fh_registro'] = $date;
            $data['fh_actualizacion'] = $date;
            $data['contador'] = 1 ;
            
            for ($i = $count-1; $i < $count; $i++) {
                $data['tipo_opcion_id'] = $arrayRow[$i];
                $modelLogBusqueda->insert($data);
            }
        } else {
            if (date('Ymd', strtotime($arrayLogBusqueda['fh_registro'])) != date('Ymd', strtotime($date))) {
                //echo '2do insert';
                $data['fh_registro'] = $date;
                $data['fh_actualizacion'] = $date;
                $data['contador'] = 1 ;
                
                for ($i = $count-1; $i < $count; $i++) {
                    $data['tipo_opcion_id'] = $arrayRow[$i];
                    $modelLogBusqueda->insert($data);
                }
            } else {
                //echo 'update';
                $data['fh_actualizacion'] = $date;
                $data['contador'] = $arrayLogBusqueda['contador']+1;
                
                $where = $modelLogBusqueda->getAdapter()->quoteInto('id = ? ', $arrayLogBusqueda['id']);
                
                for ($i = $count-1; $i < $count; $i++) {
                    $modelLogBusqueda->update($data, $where);
                }
            }
        }
    }

    public function actualizarAcumulado($idPostulante)
    {
        $modelLogPostulante = new Application_Model_LogPostulante();
        $arrayLogPostulante = $modelLogPostulante->getLogPostulanteDatos($idPostulante);
        
        $acumulado = 0;
        foreach ($arrayLogPostulante as $row) {
            $acumulado = $acumulado + $row['porcentaje'];
            $data = array(
                'acumulado' => $acumulado
            );
            $where = $modelLogPostulante->getAdapter()->quoteInto('id = ?', $row['id']);
            $modelLogPostulante->update($data, $where);
            
        }
    }
    
}
