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
        if($this->user) { $this->view->userId = $this->user->id; }
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
            $query->where($routes->getTableName().".status = ?", "In Progress");
            
            if(strlen($this->_request->getPost('from')) > 0){
                $query->where($routes->getTableName().".intermediate LIKE ?", "%".$this->_request->getPost('from')."%");
            }
            if(strlen($this->_request->getPost('to')) > 0){
                $query->where($routes->getTableName().".intermediate LIKE ?", "%".$this->_request->getPost('to')."%");
            }
            if(strlen($this->_request->getPost('date')) > 0){
                $originalDate = $this->_request->getPost('date');
                $newDate = date("Y-m-d", strtotime($originalDate));
                $query->where($routes->getTableName().".added LIKE ?", "%".$newDate."%");
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
                'route_id' => null,
                'driver_id' => $this->user->id,
                'start' => $this->_request->getPost('startForm'),
                'finish' => $this->_request->getPost('endForm'),
                'intermediate' => $this->_request->getPost('startForm').','
                                  .$this->_request->getPost('intermed').','
                                  .$this->_request->getPost('endForm'),
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
        $bind = new Application_Model_Bind();
        
        $query = $db->select()->from($routes->getTableName());
        $query->join($users->getTableName(), 
                $routes->getTableName().'.driver_id = '.$users->getTableName().'.id');
//        $query->join($drivers->getTableName(), 
//                $users->getTableName().'.id = '.$drivers->getTableName().'.user_id');
        $query->where($users->getTableName().'.id = ?', $this->user->id);
        $results = $db->fetchAll($query);
        
        $this->view->results = $results;
        
        $query2 = $db->select()->from($users->getTableName(), array('driver_flag'));
        $query2->where($users->getTableName().'.id = ?', $this->user->id);
        $driver= $db->fetchOne($query2);
        
        $query3 = $db->select()->from($routes->getTableName());
        $query3->join($bind->getTableName(), 
                $routes->getTableName().'.route_id = '.$bind->getTableName().'.route_id');
        $query3->where($bind->getTableName().'.user_id = ?', $this->user->id);
        $passangers = $db->fetchAll($query3);
        
        $this->view->results = $results;
        $this->view->driver = $driver;
        $this->view->passangerResults = $passangers;
        
        
        
    }
    
    public function updaterouteAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $db = Zend_Db_Table::getDefaultAdapter();
        $routes = new Application_Model_Routes();
        
        if($this->_request->isPost()){
            $updateData = array(
                'status' => 'Complete'
            );
            $where = array('route_id = ?' => $this->_request->getPost('data'));
            
            try {
                $db->update($routes->getTableName(), $updateData, $where);
            } catch (Zend_Exception $e) {
                $this->_helper->json(1);
            }
            $this->_helper->json(0);
        }
    }
    
    public function addpassAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $db = Zend_Db_Table::getDefaultAdapter();
        $bind = new Application_Model_Bind();
        $routes = new Application_Model_Routes();
        

        
        if($this->_request->isPost() && isset($this->user->id)){
            $query = $db->select()->from($bind->getTableName(), array('COUNT(*) as count'));
            $query->where('user_id = ?', $this->user->id);
            $query->where('route_id = ?', htmlentities($this->_request->getPost('route')));
            $counter = $db->fetchOne($query);
            
            $query2 = $db->select()->from($routes->getTableName(), array('COUNT(*) as count'));
            $query2->where('driver_id = ?', $this->user->id);
            $counter2 = $db->fetchOne($query2);
            
            if($counter > 0){
                $this->_helper->json('exista');
            }
            
            if($counter2 > 0){
                $this->_helper->json('yours');
            }
            
            $dataBind = array(
                'id' => null,
                'route_id' => htmlentities($this->_request->getPost('route')),
                'user_id' => $this->user->id
            );
            $passangersRemaining = (int)htmlentities($this->_request->getPost('pass')) - 1;
            $dataUpdatePass = array(
                'passenger' => (int)$passangersRemaining
            );
            $whereUpdate = array('route_id = ?' => htmlentities($this->_request->getPost('route')));
            try {
                $db->insert($bind->getTableName(), $dataBind);
                $db->update($routes->getTableName(), $dataUpdatePass, $whereUpdate);
            } catch (Zend_Exception $e) {
                $this->_helper->json(404);
            }
            $this->_helper->json($passangersRemaining);
            
        }
        
    }
    
    
}

