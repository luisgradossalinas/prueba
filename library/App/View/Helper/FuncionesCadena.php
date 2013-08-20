<?php
class App_View_Helper_FuncionesCadena extends Zend_View_Helper_HtmlElement
{

    protected $_cache = null;

    public function __construct()
    {

    }
    
    public function mostrarFechaSinHora($fecha)
    {
        return date("d/m/Y", $fecha->getTimestamp());
    }
}

