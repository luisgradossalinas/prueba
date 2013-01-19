<?php

class Generator_Modelo extends Zend_Db_Table
{
 
    public function cuerpoModelo($tabla)
    {
     
        $cuerpo = '';
        $primaryKey = $this->getPrimaryKey($tabla);
        
        $cuerpo .= '$id = 0;'. "\n";
        $cuerpo .= 'if (!empty($datos[\''.$primaryKey.'\'])) {'. "\n";
        $cuerpo .= "\t".'$id = (int) $datos[\''.$primaryKey.'\'];'. "\n";
        $cuerpo .= '}'. "\n\n";
        $cuerpo .= 'unset($datos[\''.$primaryKey.'\']);'. "\n";
        $cuerpo .= '$datos = array_intersect_key($datos, array_flip($this->_getCols()));'. "\n\n";
        $cuerpo .= 'if ($id > 0) {'."\n";
        $cuerpo .= "\t".'$cantidad = $this->update($datos, \''.$primaryKey.' = \' . $id);'."\n";
        $cuerpo .= "\t".'$id = ($cantidad < 1) ? 0 : $id;'."\n";
        $cuerpo .= '} else {'."\n";
        $cuerpo .= "\t".'$id = $this->insert($datos);'."\n";
        $cuerpo .= '}'. "\n\n";
        $cuerpo .= 'return $id;';
        
       
        return $cuerpo;
        
        /*
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
        //echo count($dataTabla);*/
    }
    
    public function getPrimaryKey($tabla) 
    {
        
        $db = $this->getAdapter();
        $dataTabla = $db->describeTable($tabla);
        
        foreach ($dataTabla as $key => $value) {
            
            $primary = $value['PRIMARY'];
            if ($primary == 1) {
                $campo = $key;
                break;
            }
        }
        
        return $campo;
        
    }
    
    public function getColumnas($tabla)
    {
        
        $db = $this->getAdapter();
        $dataTabla = $db->describeTable($tabla);
        
        $cuerpo = '<tr>';
        
        foreach ($dataTabla as $key => $value) {
            $campo = $key;
            $label = ucfirst($campo);
            $cuerpo .= '<th>'.$label.'</th>';
           
        }
        
        $cuerpo .= '<tr>';        
        return $cuerpo;
        
    }
    
    public function getDatosBD($tabla)
    {
        $db = $this->getAdapter();
        $dataTabla = $db->describeTable($tabla);
        
        $cuerpo = '<?php '."\n";
        $cuerpo .= "\t".'echo "<tr>";'."\n";
        
        foreach ($dataTabla as $key => $value) {
          if ($value['PRIMARY'] != 1)
            $cuerpo .= "\t".'echo "<td>".$value[\''.$key.'\']."</td>";'."\n";
        }
        
        $cuerpo .= "\t".'echo "</tr>";'."\n";
        $cuerpo .= "\t"."?>";            
                    
        return $cuerpo;
        
    }

   
}
