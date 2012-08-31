<?php

class Admin_CategoriaController extends Zend_Controller_Action
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
        Zend_Layout::getMvcInstance()->assign('active','categorias');
        $this->view->headLink()->appendStylesheet(SITE_URL.'/jquery/css/dataTables.css', 'all');
        $this->view->headScript()->appendFile(SITE_URL.'/jquery/plugins/jquery.dataTables.js');
        $this->view->headScript()->appendFile(SITE_URL.'/assets/js/bootstrap-dataTable.js');
        $this->view->headScript()->appendFile(SITE_URL.'/assets/web/categoria.js');
        $data = $this->_categoriaModel->fetchAll('estado != '.Application_Model_Categoria::ELIMINADO);
        $this->view->categoria = $data;
    }
    
    public function operacionAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $data = $this->_getAllParams();

        //Previene vulnerabilidad XSS (Cross-site scripting)
        $filtro = new Zend_Filter_StripTags();
        foreach ($data as $key => $val) {
            $data[$key] = $filtro->filter(trim($val));
        }
        
        //Muestra formulario vacío (Nuevo) o con data según petición ajax (Editar)
        if ($this->_getParam('ajax') == 'form') {
            
            if ($this->_hasParam('id')) {
                $id = $this->_getParam('id');
                $data = $this->_categoriaModel->fetchRow('id = '.$id);
                $this->_form->populate($data->toArray());
            }
            echo $this->_form;         
        }
        
        //Validación de formulario
        if ($this->_getParam('ajax') == 'validar') {
                echo $this->_form->processAjax($data);
        }
        
        //Eliminación de registro
        if ($this->_getParam('ajax') == 'delete') {
            $where = $this->getAdapter()->quoteInto('id = ?',$data['id']);
            $eliminado = Application_Model_Categoria::ELIMINADO;
            $this->_categoriaModel->update(array('estado' => $eliminado),$where);
        }
   
        // Grabar
        if ($this->_getParam('ajax') == 'save') {
            //$data['fecha_crea'] = date("Y-m-d H:i:s");
            //$data['usuario_crea'] = Zend_Auth::getInstance()->getIdentity()->id;
            $this->_categoriaModel->guardar($data);
        }
    }
    

}



