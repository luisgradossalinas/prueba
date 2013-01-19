<?php

class Generator_Form extends Zend_Db_Table
{
 
    public function cuerpoFormulario($tabla)
    {
        
        $db = $this->getAdapter();
        $dataTabla = $db->describeTable($tabla);
        
        $cuerpo = '$this->setAttrib(\'id\', \'form\');'. "\n\n";
        
        foreach ($dataTabla as $key => $value) {
            $campo = $key;
            $label = ucfirst($campo);
            $primary = $value['PRIMARY'];
            $identity = $value['IDENTITY'];
            $tipo = $value['DATA_TYPE'];
            $length = $value['LENGTH'];
            $null = $value['NULLABLE'];
            
            if ($identity != 1) {
                $cuerpo .= '$'.$campo.' = new Zend_Form_Element_Text(\''.$campo.'\');'. "\n";
                $cuerpo .= '$'.$campo.'->setLabel(\''.$label.':\');'."\n";
                
                if ($null != 1){
                    $cuerpo .=  '$'.$campo.'->setRequired();'. "\n";
                }
                
                if ($tipo == 'int') {
                    $cuerpo .=  '$'.$campo.'->addValidator(new Zend_Validate_Int());'. "\n";
                    $cuerpo .=  '$'.$campo.'->setAttrib(\'maxlength\',17);'. "\n";
                    
                } 
                else if ($tipo == 'varchar' || $tipo == 'char') {
                    $cuerpo .=  '$'.$campo.'->setAttrib(\'maxlength\','.$length.');'. "\n";
                }
                
                $cuerpo .= '$'. $campo.'->addFilter(\'StripTags\');'. "\n";
                $cuerpo .= '$this->addElement($'.$campo.');'. "\n\n";
              
            }
        }
        
        return $cuerpo;
        //print_r($dataTabla);
        //echo count($dataTabla);
    }

   
}
