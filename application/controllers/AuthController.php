<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(TRUE);
        }
        else {
            $this->view->title = 'Auth';
        }
    }

    public function indexAction()
    {
        $this->_redirect('/');
    }

    public function loginAction()
    {
        if (Zend_Auth::getInstance()->hasIdentity()){
            $this->_redirect('/');
        }

        $request = $this->getRequest();
        $form = new Application_Form_Auth();

        if ($this->getRequest()->isXmlHttpRequest() && $request->isPost()){

            $data = $request->getPost();
            if ($form->isValidPartial($data)) {
                $json = array();

                $auth = Zend_Auth::getInstance();

                $authAdapter = new Zend_Auth_Adapter_DbTable();
                $authAdapter->setTableName('accounts')
                    ->setIdentityColumn('a_login')
                    ->setCredentialColumn('a_pass');

                $login = $request->getParam('login');
                $paswd = $request->getParam('password');
                $authAdapter->setIdentity($login);
                $authAdapter->setCredential(md5($paswd));

                // Perform the authentication query, saving the result
                $result = $auth->authenticate($authAdapter);

                if($result->isValid()){
                    $data = $authAdapter->getResultRowObject(null,'a_pass');
                    $auth->getStorage()->write($data);

                    $json = array('status'=>1);
                }
                else {
                    $json = array('status'=>0, 'msgs'=>$result->getMessages());
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
            $this->view->form = new Application_Form_Auth();
        }
    }

    function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('/');
    }

}

