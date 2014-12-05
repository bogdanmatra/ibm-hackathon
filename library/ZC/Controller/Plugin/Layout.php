<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Layout
 *
 * @author Stefan Iacob
 */
class ZC_Controller_Plugin_Layout extends Zend_Controller_Plugin_Abstract {
       
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $layout = Zend_Layout::getMvcInstance();
        $view = $layout->getView();
        
        
        if(Zend_Auth::getInstance()->getIdentity())
        {
            $authStorage = Zend_Auth::getInstance()->getStorage();
            $authData = $authStorage->read();
            
            $view->userData = $authData;    
        }
        
        $formLogin = new Application_Form_Login();
        $formRegister = new Application_Form_Registration();
        $activeMenu = $request->getControllerName().'/'.$request->getActionName();
        
        $view->formLogin = $formLogin;
        $view->formRegister = $formRegister;
        $view->activeMenu = $activeMenu;
        

    }
}
