<?php

class Application_Form_Personal extends Zend_Form
{

    public function init()
    {
        $this->setAttrib('id', 'form');
        
        $nombre = new Zend_Form_Element_Text('nombre');
        $nombre->setLabel('Nombre:');
        $nombre->setRequired();
        $nombre->setAttrib('maxlength',51);
        $nombre->addFilter('StripTags');
        $this->addElement($nombre);
        
        $fecha_nacimiento = new Zend_Form_Element_Text('fecha_nacimiento');
        $fecha_nacimiento->setLabel('Fecha_nacimiento:');
        $fecha_nacimiento->addFilter('StripTags');
        $this->addElement($fecha_nacimiento);
        
        $sueldo = new Zend_Form_Element_Text('sueldo');
        $sueldo->setLabel('Sueldo:');
        $sueldo->setRequired();
        $sueldo->addFilter('StripTags');
        $this->addElement($sueldo);
        
        $hijos = new Zend_Form_Element_Text('hijos');
        $hijos->setLabel('Hijos:');
        $hijos->addValidator(new Zend_Validate_Int());
        $hijos->setAttrib('maxlength',17);
        $hijos->addFilter('StripTags');
        $this->addElement($hijos);
        
        $casado = new Zend_Form_Element_Text('casado');
        $casado->setLabel('Casado:');
        $casado->addFilter('StripTags');
        $this->addElement($casado);
    }


}

