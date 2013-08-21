<?php
class App_View_Helper_FechaMostrar extends Zend_View_Helper_HtmlElement
{
    
    public function FechaMostrar($fecha)
    {
        $fecha = new Zend_Date($fecha);
        return date("d/m/Y", $fecha->getTimestamp());
    }

}

