<?php

class Admin_ProductoController extends Zend_Controller_Action
{

    private $_form;
    private $_productoModel;
    
    public function init()
    {
        $this->_form = new Application_Form_Producto;
        $this->_productoModel = new Application_Model_Producto;
    }

    public function indexAction()
    {
        Zend_Layout::getMvcInstance()->assign('active','productos');
        $this->view->headLink()->appendStylesheet(SITE_URL.'/jquery/css/dataTables.css', 'all');
        $this->view->headScript()->appendFile(SITE_URL.'/jquery/plugins/jquery.dataTables.js');
        $this->view->headScript()->appendFile(SITE_URL.'/assets/js/bootstrap-dataTable.js');
        $this->view->headScript()->appendFile(SITE_URL.'/assets/web/producto.js');
        $data = $this->_productoModel->fetchAll();
        $this->view->producto = $data;
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
                $data = $this->_productoModel->fetchRow('id = '.$id);
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
            $eliminado = Application_Model_Producto::ELIMINADO;
            $this->_productoModel->update(array('estado' => $eliminado),$where);
        }
   
        // Grabar
        if ($this->_getParam('ajax') == 'save') {
            //$data['fecha_crea'] = date("Y-m-d H:i:s");
            //$data['usuario_crea'] = Zend_Auth::getInstance()->getIdentity()->id;
            $this->_productoModel->guardar($data);
        }
    }


}

