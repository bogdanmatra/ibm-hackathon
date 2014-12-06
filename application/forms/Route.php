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
class Application_Form_Route extends Zend_Form
{
    public function init()
    {
        $this->setMethod('post');
        $this->setAction('/main/new');
        $this->setAttrib('id', 'newRoute');
        
        $note = new Zend_Form_Element_Note(
            'title',
            array('value' => '<h2 id="titleProductDetails">Create a New Route</h2>')
        );
        
        $intermed = new Zend_Form_Element_Hidden('intermed');
        $intermed->setAttrib('readonly', 'readonly');
        $intermed->addFilter('StripTags');
        $intermed->addFilter('HtmlEntities');
        $intermed->addFilter('StringTrim');
     
        $start = new Zend_Form_Element_Text('startForm');
        $start->setLabel('Starting Point*');
        $start->setAttrib('autocomplete', 'off');
        $start->addFilter('StripTags');
        $start->addFilter('HtmlEntities');
        $start->setAttrib('class', 'form-control');
        $start->addFilter('StringTrim');
        $start->setRequired(true)->addErrorMessage('Start Location Required');
//        $start->addValidator('Regex', true, array('/^[a-zA-Z0-9.,:-\s]*$/'))->addErrorMessage('Invalid characters used');
//        $start->addValidator('StringLength', true, array(0, 255))->addErrorMessage('Required Field');
                
        $end = new Zend_Form_Element_Text('endForm');
        $end->setLabel('Destination*');
        $end->setAttrib('autocomplete', 'off');
        $end->addFilter('StripTags');
        $end->setAttrib('class', 'form-control');
        $end->addFilter('HtmlEntities');
        $end->addFilter('StringTrim');
        $end->setRequired(true)->addErrorMessage('Destination Required');
//        $end->addValidator('StringLength', true, array(0, 255))->addErrorMessage('Required Field');
        
        $routeDate = new Zend_Form_Element_Text('routeDate');
        $routeDate->setAttrib('autocomplete', 'off');
        $routeDate->setAttrib('readonly', 'readonly');
        $routeDate->setAttrib('maxlength', '10');
        $routeDate->setAttrib('class', 'form-control');
        $routeDate->setLabel('Date of Journey'.'*');
        $routeDate->addFilter('StripTags');
        $routeDate->addFilter('HtmlEntities');
        $routeDate->addFilter('StringTrim');
        $routeDate->setRequired(true)->addErrorMessage('Date Required');
        $routeDate->addValidator('Regex', true, array('/^[0-9.\s]*$/'))->addErrorMessage('Invalid characters used');
        $routeDate->addValidator('StringLength', true, array(10, 10))->addErrorMessage('Required Field');
       
        $passangers = new Zend_Form_Element_Select('passangers');
        $passangers->setLabel('No of Passangers*');
        $passangers->setAttrib('autocomplete', 'off');
        $passangers->setAttrib('class', 'form-control');
        $passangers->addFilter('StripTags');
        $passangers->addFilter('HtmlEntities');
        $passangers->addFilter('StringTrim');
        $passangers->setRequired(true)->addErrorMessage('Password Required');
        
        $passangers->setMultiOptions(array(
    //'option value' => 'option label'
            '1' => '1 Passanger',
            '2' => '2 Passangers',
            '3' => '3 Passangers',
            '4' => '4 Passangers',
            '5' => '5 Passangers',
            '6' => '6 Passangers',
        ));

        
        $submit = new Zend_Form_Element_Submit('newRoute');
        $submit->setLabel('New Route');
        $submit->setAttrib('class', 'btn btn-info');
        $submit->setAttrib('style', 'margin-top:20px');
        
        $this->addElements(array($note, $intermed, $start, $end, $passangers, $routeDate, $submit ));

        $this->setElementDecorators(array(
            'ViewHelper',
            'Label',
            'Errors'
        ));
        
        $submit->setDecorators(array(
            'ViewHelper'
        ));
        
        
        $this->setDecorators(array(
            'FormElements',
            'Form',
            array('HtmlTag', array('tag' => 'div', 'id' => 'newRouteFormContainer'))
        ));
    }
}
