<?php

class Application_Form_Usuario extends Zend_Form
{

    public function init()
    {
        $this->setAction(self::METHOD_POST);
        
        $nombre = new Zend_Form_Element_Text('nombre');
        $nombre->setLabel('Nombres:');
        $nombre->setRequired();
        $nombre->addFilter('StripTags');
        $this->addElement($nombre);
        
        $apellido = new Zend_Form_Element_Text('apellido');
        $apellido->setLabel('Apellidos:');
        $apellido->setRequired();
        $apellido->addFilter('StripTags');
        $this->addElement($apellido);
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-mail:');
        $email->setRequired();
        $email->addFilter('StripTags');
        $this->addElement($email);
    }


}

