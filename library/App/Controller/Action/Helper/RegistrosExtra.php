<?php

class App_Controller_Action_Helper_RegistrosExtra
    extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * Crea categorias por defecto en la tabla categoria_postulacion.
     * 
     * @param int $id
     */
    public function insertarCategoriaPostulacion($id)
    {
        $_categoriapostulante = new Application_Model_CategoriaPostulacion();
        $config = Zend_Registry::get("config");
        $valores = $config->empresa->categoriapostulacion->registro;
        for ($i=1;$i<=count($valores);$i++) {
            $x["id_empresa"] = $id;
            $x["orden"] = $i;
            $x["nombre"] = $config->empresa->categoriapostulacion->registro->$i;
            $_categoriapostulante->insert($x);
        }
    }
    /*
     * Nos devuelve el porcentaje de coincidencia de un anuncio y el postulante
     */
    public function PorcentajeCoincidencia($idAnuncio, $idPostulante)
    {
        $modelo = new Application_Model_AnuncioWeb();
        $result = $modelo->porcentajeCoincidencia($idAnuncio, $idPostulante);
        //var_dump($result);
        //exit;
        if ($result[0]["aptitus_match"] == null) {
            return 0;
        }
        return $result[0]["aptitus_match"];
    }
     /*
     * Nos devuelve un arreglo con el mejor nivel de estudios y carrera.
     */
    public function MejorNivelEstudiosCarrera($idPostulante)
    {
        $modelo = new Application_Model_AnuncioWeb();
        $result = $modelo->extraerMejorNivelEstudiosYCarrera($idPostulante);
        if(count($result)>0) return $result[0];
        else return array("nivelestudios"=>"Ninguno","carrera"=>"Ninguno");
    }

    /*
     * Actualizar Postulacion con match nivel y carrera
     */
    public function ActualizarPostulacion($idPostulante)
    {
        $modelo = new Application_Model_AnuncioWeb();
        $postulaciones = new Application_Model_Postulacion();
        $sql = $postulaciones->getPostulaciones($idPostulante);
        $lista = $postulaciones->getAdapter()->fetchAll($sql);
        //$zl = new ZendLucene();
        foreach ($lista as $item) {
            $idpostulacion = $item["idpostulacion"];
            $idAnuncio = $item["p.id_anuncio_web"];
//            echo $idpostulacion." ".$idAnuncio; exit;
            $match = $this->PorcentajeCoincidencia($idAnuncio, $idPostulante);
            $nivelcarrera = $this->MejorNivelEstudiosCarrera($idPostulante);
            $nivel = $nivelcarrera["nivelestudios"];
            $carrera = $nivelcarrera["carrera"];
            //echo $match." ".$nivel." ".$carrera; exit;
            $modelo->actualizarPostulacion($idpostulacion, $match, $nivel, $carrera);
            /*$zl->updateIndexPostulaciones($idpostulacion, "match", $match);
            $zl->updateIndexPostulaciones($idpostulacion, "nivelestudio", $nivel);
            $zl->updateIndexPostulaciones($idpostulacion, "nivel_estudio", $nivel);
            $zl->updateIndexPostulaciones($idpostulacion, "carrera", $carrera);*/
        }
    }

    public function descartarPostulacion($idPostulacion)
    {
        $modelo = new Application_Model_Postulacion();
        return $modelo->descartarPostulacion($idPostulacion);
    }

    public function restituirPostulacion($idPostulacion)
    {
        $modelo = new Application_Model_Postulacion();
        $modelo->restituirPostulacion($idPostulacion);
    }

    public function moverAEtapaPostulacion($idPostulacion, $etapa)
    {
        $modelo = new Application_Model_Postulacion();
        $categoria = new Application_Model_CategoriaPostulacion();
        if ($etapa!=-1) {
            $obj = $categoria->find($etapa);
        } else {
            $obj['0']->nombre = "Sin Seleccionar";
            $etapa=null;
        }
        $modelo->moveraetapaPostulacion($idPostulacion, $etapa, $obj['0']->nombre);
    }


}