<?php

class Application_Form_Usuario extends Zend_Form
{

    private $_rol;
    
    public function init()
    {
        $this->setAttrib('id', 'form');
        
        $this->_rol = new Application_Model_Rol;
        
        $dataRol = $this->_rol->combo();
        array_unshift($dataRol,array('key'=> '', 'value' => 'Seleccione'));

        
        $nombres = new Zend_Form_Element_Text('nombres');
        $nombres->setLabel('Nombres:');
        $nombres->setAttrib('maxlength',100);
        $nombres->addFilter('StripTags');
        $this->addElement($nombres);
        
        $apellidos = new Zend_Form_Element_Text('apellidos');
        $apellidos->setLabel('Apellidos:');
        $apellidos->setAttrib('maxlength',100);
        $apellidos->addFilter('StripTags');
        $this->addElement($apellidos);
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email:');
        $email->setAttrib('maxlength',45);
        $email->addFilter('StripTags');
        $this->addElement($email);
        
        $clave = new Zend_Form_Element_Text('clave');
        $clave->setLabel('Clave:');
        $clave->setAttrib('maxlength',100);
        $clave->addFilter('StripTags');
        $this->addElement($clave);
        
        $dataEstado = array('1' => 'Activo', '0' => 'Inactivo');
        array_unshift($dataEstado,array('key'=> '', 'value' => 'Seleccione'));
        
        $estado = new Zend_Form_Element_Select('estado');
        $estado->setLabel('Estado:');
        $estado->setRequired();
        $estado->setMultiOptions($dataEstado);
        $estado->addFilter('StripTags');
        $this->addElement($estado);

        
        $telefono = new Zend_Form_Element_Text('telefono');
        $telefono->setLabel('Telefono:');
        $telefono->setAttrib('maxlength',15);
        $telefono->addFilter('StripTags');
        $this->addElement($telefono);
        
        $celular = new Zend_Form_Element_Text('celular');
        $celular->setLabel('Celular:');
        $celular->setAttrib('maxlength',15);
        $celular->addFilter('StripTags');
        $this->addElement($celular);
        
        $direccion = new Zend_Form_Element_Text('direccion');
        $direccion->setLabel('Direccion:');
        $direccion->setAttrib('maxlength',100);
        $direccion->addFilter('StripTags');
        $this->addElement($direccion);
        
        $rol = new Zend_Form_Element_Select('id_rol');
        $rol->setLabel('Rol:');
        $rol->setRequired();
        $rol->setMultiOptions($dataRol);
        $this->addElement($rol);
        
        $fecha_nac = new Zend_Form_Element_Text('fecha_nac');
        $fecha_nac->setLabel('Fecha_nac:');
        $fecha_nac->setRequired();
        $fecha_nac->addValidator(new Zend_Validate_Date('DD-MM-YYYY'));
        $fecha_nac->setAttrib('maxlength',10);
        $fecha_nac->setAttrib('class','v_datepicker');
        $fecha_nac->addFilter('StripTags');
        $this->addElement($fecha_nac);
        
        $fecha_registro = new Zend_Form_Element_Text('fecha_registro');
        $fecha_registro->setLabel('Fecha_registro:');
        $fecha_registro->addValidator(new Zend_Validate_Date('DD-MM-YYYY'));
        $fecha_registro->setAttrib('maxlength',10);
        $fecha_registro->setAttrib('class','v_datepicker');
        $fecha_registro->addFilter('StripTags');
        $this->addElement($fecha_registro);
        
        $ultimo_login = new Zend_Form_Element_Text('ultimo_login');
        $ultimo_login->setLabel('Ultimo_login:');
        $ultimo_login->addValidator(new Zend_Validate_Date('DD-MM-YYYY'));
        $ultimo_login->setAttrib('maxlength',10);
        $ultimo_login->setAttrib('class','v_datepicker');
        $ultimo_login->addFilter('StripTags');
        $this->addElement($ultimo_login);
    }

    public function populate($data)
    {
        if (isset($data['fecha_nac']) && ($data['fecha_nac'] == App_View_Helper_FechaMostrar::DEFAULT_DATE || $data['fecha_nac'] == App_View_Helper_FechaMostrar::DEFAULT_DATETIME)) {
            unset($data['fecha_nac']);
        } else {
            $data['fecha_nac'] = new Zend_Date($data['fecha_nac'],'yyyy-mm-dd');
            $data['fecha_nac'] = $data['fecha_nac']->get('dd/mm/yyyy');
            } 
            if (isset($data['fecha_registro']) && ($data['fecha_registro'] == App_View_Helper_FechaMostrar::DEFAULT_DATE || $data['fecha_registro'] == App_View_Helper_FechaMostrar::DEFAULT_DATETIME)) {
            unset($data['fecha_registro']);
        } else {
            $data['fecha_registro'] = new Zend_Date($data['fecha_registro'],'yyyy-mm-dd');
            $data['fecha_registro'] = $data['fecha_registro']->get('dd/mm/yyyy');
            } 
            if (isset($data['ultimo_login']) && ($data['ultimo_login'] == App_View_Helper_FechaMostrar::DEFAULT_DATE || $data['ultimo_login'] == App_View_Helper_FechaMostrar::DEFAULT_DATETIME)) {
            unset($data['ultimo_login']);
        } else {
            $data['ultimo_login'] = new Zend_Date($data['ultimo_login'],'yyyy-mm-dd');
            $data['ultimo_login'] = $data['ultimo_login']->get('dd/mm/yyyy');
            } 
        return $this->setDefaults($data);
    }


}

