<?php
/**
 * Validator for password confirmation
 */
class Validate_PasswordConfirmation extends Zend_Validate_Abstract {

    const NOT_MATCH = 'notMatch';

    protected $_messageTemplates = array(
        self::NOT_MATCH => 'Password confirmation does not match'
    );

    public function isValid($value, $context = null) {
        $value = (string) $value;
        $this->_setValue($value);

        if (is_array($context)) {
            if (isset($context['password']) && ($value == $context['password'])) {
                return true;
            }
        } elseif (is_string($context) && ($value == $context)) {
            return true;
        }

        $this->_error(self::NOT_MATCH);
        return false;
    }
}

class Application_Form_Reg extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post');
        $this->setAttrib('id','form');

        $this->addElement('text', 'fname', array(
            'label'      => 'First Name:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'id'    =>  'fname',
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(3, 30)),
                array('regex', false, '/^([a-z\-]+)$/si' )
            )
        ));

        $this->addElement('text', 'lname', array(
            'id'    => 'lname',
            'label'      => 'Last Name:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(3, 30)),
                array('regex', false, '/^([a-z\-]+)$/si' )
            )
        ));

        $this->addElement('text', 'email', array(
            'id'    => 'email',
            'label'      => 'Email:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(3, 30)),
                'EmailAddress'
            )
        ));

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

        $passConfirmation = new Validate_PasswordConfirmation();
        $this->addElement('password', 'password', array(
            'id'    => 'password',
            'label' => 'Password:',
            'required'  => true,
            'filters'   => array('StringTrim'),
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(3, 30))
            )
        ));

        $this->addElement('password', 'pass2', array(
            'id'    => 'pass2',
            'label' => 'Confirm password:',
            'required'  => true,
            'ignore'    => true,
            'filters'   => array('StringTrim'),
            'validators' => array(
                $passConfirmation,
                array('validator' => 'StringLength', 'options' => array(3, 30))
            )
        ));

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Join',
        ));

    }
}

