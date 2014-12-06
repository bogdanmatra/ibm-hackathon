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
        
    }
    
    public function filterAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $db = Zend_Db_Table::getDefaultAdapter();
        $routes = new Application_Model_Routes();
        $users = new Application_Model_Users();
        $drivers = new Application_Model_Driver();
        
        
        if($this->_request->isPost()){
            $query = $db->select()->from($routes->getTableName());
            $query->join($users->getTableName(), 
                    $routes->getTableName().'.driver_id = '.$users->getTableName().'.id');
            $query->join($drivers->getTableName(), 
                    $users->getTableName().'.id = '.$drivers->getTableName().'.user_id');
            
            if(strlen($this->_request->getPost('from')) > 0){
                $query->where($routes->getTableName().".start LIKE ?", "%".$this->_request->getPost('from')."%");
                $query->orWhere($routes->getTableName().".intermediate LIKE ?", "%".$this->_request->getPost('from')."%");
            }
            if(strlen($this->_request->getPost('to')) > 0){
                $query->where($routes->getTableName().".finish LIKE ?", "%".$this->_request->getPost('to')."%");
                $query->orWhere($routes->getTableName().".intermediate LIKE ?", "%".$this->_request->getPost('to')."%");
            }
            if(strlen($this->_request->getPost('date')) > 0){
                $originalDate = $this->_request->getPost('date');
                $newDate = date("Y-m-d", strtotime($originalDate));
                $query->having($routes->getTableName().".added LIKE ?", $newDate."%");
            }
            
            $results = $db->fetchAll($query);
            $this->_helper->json($results);
        }
        

        
    }
    
    public function newAction()
    {
        $newForm = new Application_Form_Route();
        $this->view->newForm = $newForm;
        
        $db = Zend_Db_Table::getDefaultAdapter();
        $routes = new Application_Model_Routes();
        
        if ($this->getRequest()->isPost() && $newForm->isValid($this->_request->getPost())) {
            $dataRoute = array(
                'id' => null,
                'driver_id' => $this->user->id,
                'start' => $this->_request->getPost('startForm'),
                'finish' => $this->_request->getPost('endForm'),
                'intermediate' => $this->_request->getPost('intermed'),
                'date' => $this->_request->getPost('routeDate'),
                'passenger' => $this->_request->getPost('passangers')
            );
            
            $db->insert($routes->getTableName(), $dataRoute);
            $this->redirect('/main/active');
        }
        
    }
    
    public function myroutesAction(){
        $db = Zend_Db_Table::getDefaultAdapter();
        $routes = new Application_Model_Routes();
        $users = new Application_Model_Users();
//        $drivers = new Application_Model_Driver();
        
        $query = $db->select()->from($routes->getTableName());
        $query->join($users->getTableName(), 
                $routes->getTableName().'.driver_id = '.$users->getTableName().'.id');
//        $query->join($drivers->getTableName(), 
//                $users->getTableName().'.id = '.$drivers->getTableName().'.user_id');
        $query->where($users->getTableName().'.id = ?', $this->user->id);
        $results = $db->fetchAll($query);
        
        $this->view->results = $results;
        
    }
    
    
}

