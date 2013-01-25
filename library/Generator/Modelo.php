<?php

class Generator_Modelo extends Zend_Db_Table
{
 
    public function cuerpoModelo($tabla)
    {
     
        $cuerpo = '';
        $primaryKey = $this->getPrimaryKey($tabla);
        
        $cuerpo .= '$id = 0;'. "\n";
//        $cuerpo .= 'if (!empty($datos[\''.$primaryKey.'\'])) {'. "\n";
//        $cuerpo .= "\t".'$id = (int) $datos[\''.$primaryKey.'\'];'. "\n";
//        $cuerpo .= '}'. "\n\n";
//        $cuerpo .= 'unset($datos[\''.$primaryKey.'\']);'. "\n";
        
        $cuerpo .= 'if (!empty($datos["id"])) {'. "\n";
        $cuerpo .= "\t".'$id = (int) $datos["id"];'. "\n";
        $cuerpo .= '}'. "\n\n";
        $cuerpo .= 'unset($datos["id"]);'. "\n";
        
        $cuerpo .= '$datos = array_intersect_key($datos, array_flip($this->_getCols()));'. "\n\n";
        $cuerpo .= 'if ($id > 0) {'."\n";
        $cuerpo .= "\t".'$cantidad = $this->update($datos, \''.$primaryKey.' = \' . $id);'."\n";
        $cuerpo .= "\t".'$id = ($cantidad < 1) ? 0 : $id;'."\n";
        $cuerpo .= '} else {'."\n";
        
        if (!$this->esIdentity($tabla)) {
            $cuerpo .= "\t".'$GM = new Generator_Modelo();'."\n";
            $cuerpo .= "\t".'$datos[\''.$primaryKey.'\'] = $GM->maxCodigo($this->_name);'."\n";
        }
        
        $cuerpo .= "\t".'$id = $this->insert($datos);'."\n";
        $cuerpo .= '}'. "\n\n";
        $cuerpo .= 'return $id;';
        
        return $cuerpo;
        
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
    
    public function maxCodigo ($tabla)
    {
        $db = $this->getAdapter();
        $primaryKey = $this->getPrimaryKey($tabla);
        $max = $db->select()->from($tabla,array('ifnull(max('.$primaryKey.'+1),1)'))->query()->fetchColumn();
        return $max;
        
    }
    
    public function esIdentity($tabla)
    {
        
        $db = $this->getAdapter();
        $dataTabla = $db->describeTable($tabla);
        $valor = true;
        
        foreach ($dataTabla as $key => $value) {
            $primary = $value['PRIMARY'];
            $identity = $value['IDENTITY'];
            
            if ($primary == 1) {
                if ($identity == 1) {
                
                    $value = true;
                }
                else {
                    $valor = false;
                }
                break;
            }  
            
        }
        
        return $valor;
    }
    
    public function getColumnas($tabla)
    {
        
        $db = $this->getAdapter();
        $dataTabla = $db->describeTable($tabla);
        
        $cuerpo = '<tr>';
        $cuerpo .= '<th></th>';
        foreach ($dataTabla as $key => $value) {
            $label = ucfirst($key);
            if ($value['PRIMARY'] != 1)
            $cuerpo .= '<th>'.$label.'</th>';
           
        }
        
        $cuerpo .= '</tr>';        
        return $cuerpo;
        
    }
    
    public function getDatosBD($tabla)
    {
        $db = $this->getAdapter();
        $dataTabla = $db->describeTable($tabla);
        
        $cuerpo = '<?php '."\n";
        
        foreach ($dataTabla as $key => $value) {
          if ($value['PRIMARY'] != 1)
            $cuerpo .= "\t".'echo "<td>".$value[\''.$key.'\']."</td>";'."\n";
        }
        
        $cuerpo .= "\t".'echo "</tr>";'."\n";
        $cuerpo .= "\t"."?>";            
                    
        return $cuerpo;
        
    }

   
}
