<?php

class RegController extends Zend_Controller_Action
{

    public function init()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(TRUE);
        }
        else {
            $this->view->title = 'Registration';
        }
    }

    public function preDispatch()
    {
        if (Zend_Auth::getInstance()->hasIdentity()){
            $this->_forward('index','list');
        }
    }

    public function indexAction()
    {
        $form = new Application_Form_Reg();
        $request = $this->getRequest();

        if ($request->isXmlHttpRequest() && $request->isPost()) {
            $data = $request->getPost();
            /*$accounts = new Application_Model_AccountMapper();

            $where = $accounts->getAdapter()->quoteInto('a_login = ?', $data['login']);
            $accounts->fetchRow($where);*/


            if ($form->isValidPartial($data)) {
                $json = array();

                $accounts = new Application_Model_AccountMapper();
                $accounts_t = $accounts->getDbTable();
                $account = $accounts_t->fetchRow($accounts_t->select()->where('a_login = ?', $data['login']));
                if ($account!=NULL){
                    $json['login'] = array('somekey'=>'This login already used.');
                }

                $account = $accounts_t->fetchRow($accounts_t->select()->where('a_email = ?', $data['email']));
                if ($account!=NULL){
                    $json['email'] = array('somekey'=>'This email already  used.');
                }

                if (count($json)==0){
                    $data['password'] = md5($data['password']);
                    $account = new Application_Model_Account($data);
                    $accounts->save($account);

                    $json = array('status'=>1);
                }
                else {
                    $json = array('status'=>0, 'msgs'=>$json);
                }
            }
            else {
                $json = array('status'=>0, 'msgs'=>$form->getMessages());
            }

            $response = $this->getResponse();
            $response->setBody(Zend_Json::encode($json))
                ->setHeader('content-type', 'application/json', true);
        }
        else {
            $form->setAction($this->view->url());
            $this->view->form = $form;
        }
    }


}

