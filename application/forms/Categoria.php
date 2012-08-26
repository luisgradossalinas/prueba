<?php

class Application_Form_Categoria extends Zend_Form
{

    public function init()
    {
        $this->setAction(self::METHOD_POST);
        $this->setAttrib('id', 'form-categoria');
        
        $nombre = new Zend_Form_Element_Text('nom_cat');
        $nombre->setLabel('Nombre:');
        $nombre->setRequired();
        $nombre->addFilter('StripTags');
        $this->addElement($nombre);
        
        
        $estado = new Zend_Form_Element_Select('estado');
        $estado->setLabel('Estado:');
        $estado->setRequired();
        $estado->setMultiOptions(array('1' => 'Activo', '0' => 'Inactivo'));
        $estado->addFilter('StripTags');
        $this->addElement($estado);
   
    }


}

