<?php

class Application_Form_Auth extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('id','form');

        $this->addElement('text', 'login', array(
            'id'    => 'login',
            'label'      => 'Login:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(3, 30)),
                array('regex', false, '/^([a-z\-]+)$/si' )
            )
        ));

        $this->addElement('password', 'password', array(
            'id'    => 'password',
            'label' => 'Password:',
            'required'  => true,
            'filters'   => array('StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(3, 30))
            )
        ));

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Sign In',
        ));
    }


}

