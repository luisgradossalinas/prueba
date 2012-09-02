<?php
/**
 * Description of Util
 * 
 * @author eanaya
 *
 */
class App_Controller_Action_Helper_Util extends Zend_Controller_Action_Helper_Abstract
{
    public function getRepetido($pattern, $post)
    {
        $currentValues = array();
        foreach ($post as $key => $value) {
            if (preg_match($pattern, $key)) {
                if (in_array($value, $currentValues) && $value != -1) {
                    return $value;
                } else {
                    $currentValues[] = $value;
                }
            }
        }
        return false;
    }
    
    public function getUbigeo($valuesPostulante)
    {
        $idPais = $valuesPostulante['pais_residencia'];
        $idDep = $valuesPostulante['id_departamento'];
        $idProv = $valuesPostulante['id_provincia'];
        $idDist = $valuesPostulante['id_distrito'];
        
        //sacar de constante en ubigeo
        $idPeru = Application_Model_Ubigeo::PERU_UBIGEO_ID;
        $idLima = Application_Model_Ubigeo::LIMA_UBIGEO_ID;
        $idLimaProv = Application_Model_Ubigeo::LIMA_PROVINCIA_UBIGEO_ID;
        $idCallaoProv = Application_Model_Ubigeo::CALLAO_PROVINCIA_UBIGEO_ID;
        
        if ($idPais != $idPeru) {
            $idUbigeo = $idPais;
        } else if ($idDep != $idLima) {
            $idUbigeo = $idDep;
        } else if ($idProv != $idLimaProv && $idProv != $idCallaoProv) {
            $idUbigeo = $idProv;
        } else {
            $idUbigeo = $idDist;
        }
        
        return $idUbigeo;
    } 
}
