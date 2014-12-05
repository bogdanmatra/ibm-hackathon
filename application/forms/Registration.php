<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Company
 *
 * @author Stefan Iacob
 */
class Application_Form_Registration extends Zend_Form {
    
    public function init() {
        $this->setMethod('post');
        $this->setAttrib('id', 'registerInfo');
        
        $firstName = new Zend_Form_Element_Text('firstName');
        $firstName->setAttrib('autocomplete', 'off');
        $firstName->setAttrib('maxlength', '55');
        $firstName->setLabel('First Name'.'*');
        $firstName->addFilter('StripTags');
        $firstName->addFilter('HtmlEntities');
        $firstName->addFilter('StringTrim');
        $firstName->setRequired(true)->addErrorMessage('Required Field');
        $firstName->addValidator('Regex', true, array('/^[a-zA-Z0-9.-\s]*$/'))->addErrorMessage('Invalid characters used');
        $firstName->addValidator('StringLength', true, array(1, 95))->addErrorMessage('Invalid Length');
        
        $lastName = new Zend_Form_Element_Text('lastName');
        $lastName->setAttrib('autocomplete', 'off');
        $lastName->setAttrib('maxlength', '55');
        $lastName->setLabel('Last Name'.'*');
        $lastName->addFilter('StripTags');
        $lastName->addFilter('HtmlEntities');
        $lastName->addFilter('StringTrim');
        $lastName->setRequired(true)->addErrorMessage('Required Field');
        $lastName->addValidator('Regex', true, array('/^[a-zA-Z0-9.,:-\s]*$/'))->addErrorMessage('Invalid characters used');
        
        $telephone = new Zend_Form_Element_Text('telephone');
        $telephone->setAttrib('autocomplete', 'off');
        $telephone->setAttrib('maxlength', '15');
        $telephone->setLabel('Telephone'.'*');
        $telephone->addFilter('StripTags');
        $telephone->addFilter('HtmlEntities');
        $telephone->addFilter('StringTrim');
        $telephone->setRequired(true)->addErrorMessage('Required Field');
        $telephone->addValidator('Regex', true, array('/^[0-9.+\s]*$/'))->addErrorMessage('Invalid characters used');
        
        $email = new Zend_Form_Element_Text('emailRegister');
        $email->setAttrib('autocomplete', 'off');
        $email->setLabel('Email'.'*');
        $email->addFilter('StripTags');
        $email->addFilter('HtmlEntities');
        $email->addFilter('StringTrim');
        $email->setRequired(true)->addErrorMessage('Required');
        $email->addValidator('EmailAddress')->addErrorMessage('Invalid Email used');
        $email->addValidator('StringLength', true, array(0, 255))->addErrorMessage('Required Field');
        
        $password = new Zend_Form_Element_Password('passwordRegister');
        $password->setAttrib('autocomplete', 'off');
        $password->setLabel('Password*');
        $password->addFilter('StripTags');
        $password->addFilter('HtmlEntities');
        $password->addFilter('StringTrim');
        $password->setRequired(true)->addErrorMessage('Password Required');
        $password->addValidator('StringLength', true, array(0, 255))->addErrorMessage('Required Field');
        
        $driverCheck = new Zend_Form_Element_Checkbox('driverCheck');
        $driverCheck->setDescription('Driver');
        $driverCheck->setUncheckedValue(0);
        
        $carModel = new Zend_Form_Element_Text('carModel');
        $carModel->setAttrib('autocomplete', 'off');
        $carModel->setAttrib('maxlength', '55');
        $carModel->setLabel('Car Model'.'*');
        $carModel->addFilter('StripTags');
        $carModel->addFilter('HtmlEntities');
        $carModel->addFilter('StringTrim');
        $carModel->addValidator('Regex', true, array('/^[a-zA-Z0-9.,:-\s]*$/'))->addErrorMessage('Invalid characters used');
        
        $carMake = new Zend_Form_Element_Text('carMake');
        $carMake->setAttrib('autocomplete', 'off');
        $carMake->setAttrib('maxlength', '55');
        $carMake->setLabel('Car Make'.'*');
        $carMake->addFilter('StripTags');
        $carMake->addFilter('HtmlEntities');
        $carMake->addFilter('StringTrim');
        $carMake->addValidator('Regex', true, array('/^[a-zA-Z0-9.,:-\s]*$/'))->addErrorMessage('Invalid characters used');
        
        $driverLicense = new Zend_Form_Element_Text('driverLicense');
        $driverLicense->setAttrib('autocomplete', 'off');
        $driverLicense->setAttrib('readonly', 'readonly');
        $driverLicense->setAttrib('maxlength', '10');
        $driverLicense->setLabel('Driver License Since'.'*');
        $driverLicense->addFilter('StripTags');
        $driverLicense->addFilter('HtmlEntities');
        $driverLicense->addFilter('StringTrim');
        $driverLicense->addValidator('Regex', true, array('/^[0-9.\s]*$/'))->addErrorMessage('Invalid characters used');
        
        
        $this->addElements(array($firstName, $lastName, $telephone, $email, $password, $driverCheck,
            $carModel, $carMake, $driverLicense));
        
        $this->setElementDecorators(array(
            'ViewHelper',
            'Label',
            'Errors'
        ));
                
        $this->setDecorators(array(
            'FormElements',
            'Form',
            array('HtmlTag', array('tag' => 'div', 'id' => 'registerFormContainer'))
        ));

        $driverCheck->setDecorators(array(
            'ViewHelper',
            array('Description', array('placement' => Zend_Form_Decorator_Abstract::APPEND, 
                                       'tag' => 'em', 
                                       'class' => 'activeCheck')),
            array('HtmlTag', array('tag' => 'div', 'id' => 'driverCheckBox'))
        ));
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Register');
        $submit->setAttrib('class', 'btn btn-success pull-right');
        $submit->setAttrib('id', 'submitUser');
        
        $this->addElement($submit);
        
        $submit->setDecorators(array(
            'ViewHelper',
        ));
    }
}
