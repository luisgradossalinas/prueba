<?php

class Application_Form_Docente extends Zend_Form
{

    public function init()
    {
        $this->setAttrib('id', 'form');
        
        $nombre = new Zend_Form_Element_Text('nombre');
        $nombre->setLabel('Nombre:');
        $nombre->setAttrib('maxlength',100);
        $nombre->addFilter('StripTags');
        $this->addElement($nombre);
        
        $apellido_paterno = new Zend_Form_Element_Text('apellido_paterno');
        $apellido_paterno->setLabel('Apellido_paterno:');
        $apellido_paterno->setAttrib('maxlength',100);
        $apellido_paterno->addFilter('StripTags');
        $this->addElement($apellido_paterno);
        
        $apellido_materno = new Zend_Form_Element_Text('apellido_materno');
        $apellido_materno->setLabel('Apellido_materno:');
        $apellido_materno->setAttrib('maxlength',100);
        $apellido_materno->addFilter('StripTags');
        $this->addElement($apellido_materno);
        
        $telefono = new Zend_Form_Element_Text('telefono');
        $telefono->setLabel('Telefono:');
        $telefono->setAttrib('maxlength',20);
        $telefono->addFilter('StripTags');
        $this->addElement($telefono);
        
        $fecha_nac = new Zend_Form_Element_Text('fecha_nac');
        $fecha_nac->setLabel('Fecha_nac:');
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
        return $this->setDefaults($data);
    }


}

