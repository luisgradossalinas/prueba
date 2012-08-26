<?php

class Default_CategoriaController extends Zend_Controller_Action
{

    private $_form;
    private $_categoriaModel;
    
    public function init()
    {
        $this->_form = new Application_Form_Categoria;
        $this->_categoriaModel = new Application_Model_Categoria;
    }

    public function indexAction()
    {
        // action body
    }

    public function formAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        if ($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $data = $this->_categoriaModel->fetchRow('id = '.$id);
            $this->_form->populate($data->toArray());
        }
        echo $this->_form;
    }
    
    public function nuevoAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $data = $this->_getAllParams();

        $filtro = new Zend_Filter_StripTags();
        foreach ($data as $key => $val) {
            $data[$key] = $filtro->filter(trim($val));
        }
        // Validacion
        if ($this->_getParam('ajax') == 'validar') {
                echo $this->_form->processAjax($data);
        }
        
        // Mostrar formulario
        /*if ($this->_getParam('ajax') == 'form') {
            echo $this->_form;
        }*/
        // Grabar Registro
        
        if ($this->_getParam('ajax') == 'save') {
            $data['fecha_crea'] = date("Y-m-d H:i:s");
            //$data['usuario_crea'] = Zend_Auth::getInstance()->getIdentity()->id;
            $value = $this->_categoriaModel->guardar($data);
            echo Zend_Json::encode(array('value' => $value));
        }
    }


}



