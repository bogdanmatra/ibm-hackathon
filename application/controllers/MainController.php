<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MainController extends Zend_Controller_Action
{
    public function init(){
        /* Initialize action controller here */ 
        
        if(Zend_Auth::getInstance()->hasIdentity() !== null){
            $user = Zend_Auth::getInstance()->getIdentity();
        } else {
            $user = "";
        }
        $this->view->user = $user;
        $this->user = $user;
    }
    
    public function homeAction()
    {
        // action body
    }
    
    public function activeAction()
    {
        // action body
    }
    
}

