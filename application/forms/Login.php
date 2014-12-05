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
        
//        $translate = Zend_Registry::get('Zend_Translate');
//        echo $translate->translate("1");
 
        $this->setMethod('post');
        $this->setAction('/index/login');
        $this->setAttrib('id', 'msform');
        
//        $note = new Zend_Form_Element_Note(
//            'title',
//            array('value' => '<h2 id="small-title">Welcome to</h2><p id="large-title">Invoices.Guru !</p>')
//        );
        
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
        $submit->setAttrib('class', 'submit action-button');
        
        $register = new Zend_Form_Element_Button('register');
        $register->setLabel('Register');
        
        $token = new Zend_Form_Element_Hash('token');
        $token->setSalt(md5(uniqid(rand(), true)));
        
        $this->addElements(array($email, $password, $link, $submit, $register, $token));

        $this->setElementDecorators(array(
            'ViewHelper'
        ));
        
        $token->setDecorators(array(
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
        
//        $icon = new Zend_Form_Element_Note(
//            'icon',
//            array('value' => '<div class="icon"><img src="../images/app/ornament.png" class="form-icon" /><div>')
//        );
//        $this->addElements(array($icon));
//        $icon->setDecorators(array(
//            'ViewHelper',
//        ));
        
//        $account = new Zend_Form_Element_Note(
//            'account',
//            array('value' => '<div id="account"><a href=# class="need_account">Need an account?</a><div>')
//        );
//        $this->addElements(array($account));
//        $account->setDecorators(array(
//            'ViewHelper',
//        ));
    }
}
