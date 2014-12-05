<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Login
 * the login form used by the users to simply sign into the site
 * zend form_element with filters and validators
 * @author Stefan Iacob
 */
class Application_Form_Login extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
        $this->setAction('/index/login');
        $this->setAttrib('id', 'msform');
     
        $email = new Zend_Form_Element_Text('email');
        $email->setAttrib('placeholder', 'E-mail');
        $email->setAttrib('autocomplete', 'off');
        $email->addFilter('StripTags');
        $email->addFilter('HtmlEntities');
        $email->addFilter('StringTrim');
        $email->setRequired(true)->addErrorMessage('Username Required');
        $email->addValidator('EmailAddress')->addErrorMessage('Invalid Email used');
        $email->addValidator('StringLength', true, array(0, 255))->addErrorMessage('Required Field');
                
        $password = new Zend_Form_Element_Password('password');
        $password->setAttrib('placeholder', 'Password');
        $password->setAttrib('autocomplete', 'off');
        $password->addFilter('StripTags');
        $password->addFilter('HtmlEntities');
        $password->addFilter('StringTrim');
        $password->setRequired(true)->addErrorMessage('Password Required');
        $password->addValidator('StringLength', true, array(0, 255))->addErrorMessage('Required Field');

        $link = new Zend_Form_Element_Note(
            'forgot_password',
            array('value' => '<a href="#" id="link">Forgot your password ?</a>')
        );

        $submit = new Zend_Form_Element_Submit('SignIn');
        $submit->setLabel('Sign In');
        $submit->setAttrib('class', 'btn btn-info');
        
        $register = new Zend_Form_Element_Button('register');
        $register->setLabel('Register');
        $register->setAttrib('class', 'btn btn-warning');
        
        $this->addElements(array($email, $password, $submit, $register, $link));

        $this->setElementDecorators(array(
            'ViewHelper'
        ));
        
        $submit->setDecorators(array(
            'ViewHelper'
        ));
        
        $register->setDecorators(array(
            'ViewHelper'
        ));
        
        $this->setDecorators(array(
            'FormElements',
            'Form'
        ));
    }
}
