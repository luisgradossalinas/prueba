<?php

class App_Controller_Action extends Zend_Controller_Action
{

    public function init()
    {
        
    }
  
    public function getConfig()
    {
        return Zend_Registry::get('config');
    }

    public function getCache()
    {
        return Zend_Registry::get('cache');
    }

    public function getAdapter()
    {
        return Zend_Registry::get('db');
    }

    public function getLog()
    {
        return Zend_Registry::get('log');
    }

 }