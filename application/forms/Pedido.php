<?php

class Application_Form_Pedido extends Zend_Form
{

    private $_rol;
    
    public function init()
    {
        $this->_rol = new Application_Model_Rol;
        $this->setAttrib('id', 'form');
        
        $nombre = new Zend_Form_Element_Text('nombres');
        $nombre->setLabel('Nombres:');
        $nombre->setRequired();
        $nombre->addFilter('StripTags');
        $this->addElement($nombre);
        
        $apellido = new Zend_Form_Element_Text('apellidos');
        $apellido->setLabel('Apellidos:');
        $apellido->setRequired();
        $apellido->addFilter('StripTags');
        $this->addElement($apellido);
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('E-mail:');
        $email->setRequired();
        $email->addFilter('StripTags');
        $email->addValidator(new Zend_Validate_EmailAddress());
        $this->addElement($email);
        
        $dataRol = $this->_rol->combo();
        array_unshift($dataRol,array('key'=> '', 'value' => 'Seleccione'));
        
        $rol = new Zend_Form_Element_Select('id_rol');
        $rol->setLabel('Rol:');
        $rol->setRequired();
        $rol->setMultiOptions($dataRol);
        $this->addElement($rol);
        
        $telefono = new Zend_Form_Element_Text('telefono');
        $telefono->setLabel('Teléfono:');
        $telefono->setRequired();
        $telefono->addFilter('StripTags');
        $this->addElement($telefono);
        
        $cel = new Zend_Form_Element_Text('celular');
        $cel->setLabel('Celular:');
        $cel->setRequired();
        $cel->addFilter('StripTags');
        $this->addElement($cel);
        
        $direccion = new Zend_Form_Element_Text('direccion');
        $direccion->setLabel('Dirección:');
        $direccion->setRequired();
        //$direccion->setAttrib("class","input-xlarge");
        $direccion->addFilter('StripTags');
        $this->addElement($direccion);
        
       // <input type="text" class="datepicker" value="12-02-2012" data-date-format="dd-mm-yyyy" data-date="12-02-2012">
        $fechaNac = new Zend_Form_Element_Text('fecha_nac');
        $fechaNac->setLabel('Fecha nac:');
        $fechaNac->setRequired();
        $fechaNac->setAttribs(array('class' => 'datepicker', 'data-date-format' => 'dd-mm-yyyy'));
        $fechaNac->addFilter('StripTags');
        $this->addElement($fechaNac);
        
        
        $estado = new Zend_Form_Element_Select('estado');
        $estado->setLabel('Estado:');
        $estado->setRequired();
        $estado->setMultiOptions(array('1' => 'Activo', '0' => 'Inactivo'));
        $estado->addFilter('StripTags');
        $this->addElement($estado);
    }


}

