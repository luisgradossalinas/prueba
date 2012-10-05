<?php

class Application_Form_Recurso extends Zend_Form
{

    public function init()
    {
        $this->setAttrib('id', 'form');
        
        $nombre = new Zend_Form_Element_Text('nombre');
        $nombre->setLabel('Nombre:');
        $nombre->setRequired();
        $nombre->addFilter('StripTags');
        $nombre->setAttrib('maxlength', 50);
        $nombre->addValidator(new Zend_Validate_StringLength(array('min' => 3)));
        $nombre->addValidator('Alpha', false, array('allowWhiteSpace' => true));
        $this->addElement($nombre);
        
        $key = new Zend_Form_Element_Text('access');
        $key->setLabel('Access:');
        $key->setRequired();
        $key->addFilter('StripTags');
        $key->setAttrib('maxlength', 50);
        $key->addValidator(new Zend_Validate_StringLength(array('min' => 4)));
        $this->addElement($key);
        
        $padre = new Zend_Form_Element_Text('padre');
        $padre->setLabel('Padre:');
        $padre->setRequired();
        $padre->addFilter('StripTags');
        $this->addElement($padre);
        
        $orden = new Zend_Form_Element_Text('orden');
        $orden->setLabel('Orden:');
        $orden->setRequired();
        $orden->addFilter('StripTags');
        $this->addElement($orden);
        
        $url = new Zend_Form_Element_Text('url');
        $url->setLabel('Url:');
        $url->setRequired();
        $url->addFilter('StripTags');
        $this->addElement($url);
        
        $tab = new Zend_Form_Element_Text('tab');
        $tab->setLabel('Tab:');
        $tab->setRequired();
        $tab->addFilter('StripTags');
        $this->addElement($tab);
        
        $estado = new Zend_Form_Element_Select('estado');
        $estado->setLabel('Estado:');
        $estado->setRequired();
        $estado->setMultiOptions(array('1' => 'Activo', '0' => 'Inactivo'));
        $estado->addFilter('StripTags');
        $this->addElement($estado);
   
    }


}

