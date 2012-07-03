<?php

class ListController extends Zend_Controller_Action
{

    public function init()
    {
        if (!Zend_Auth::getInstance()->hasIdentity()){
            $this->_redirect('/');
        }
        $this->view->title = 'Users list';
    }

    public function indexAction()
    {
        $account = new Application_Model_AccountMapper();
        $this->view->entries = $account->fetchAll();
    }


}

