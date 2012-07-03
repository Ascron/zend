<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->title = 'Index';
    }

    public function preDispatch()
    {
        if (Zend_Auth::getInstance()->hasIdentity()){
            $this->_forward('index','list');
        }
        else {
            $this->_forward('login','auth');
        }
    }

    public function indexAction()
    {
        // action body
    }


}
