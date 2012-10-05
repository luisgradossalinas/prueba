<?php

class Application_Form_Contacto extends Zend_Form
{

    public function init()
    {
        $this->setAttrib('id', 'form');
        
        $nombre = new Zend_Form_Element_Text('nombres');
        $nombre->setLabel('Nombres:');
        $nombre->setRequired();
        $nombre->addFilter('StripTags');
        $nombre->setAttrib('maxlength', 50);
        $nombre->addValidator(new Zend_Validate_StringLength(array('min' => 4)));
        $nombre->addValidator('Alpha', false, array('allowWhiteSpace' => true));
        $this->addElement($nombre);
        
        $respondido = new Zend_Form_Element_Checkbox('respondido');
        $respondido->setLabel('Respondido:');
        $respondido->setRequired();
        $respondido->addFilter('StripTags');
        $this->addElement($respondido);
        
   
    }


}

