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
        $db = Zend_Db_Table::getDefaultAdapter();
        $routes = new Application_Model_Routes();
        $users = new Application_Model_Users();
        $drivers = new Application_Model_Driver();
        
        
        $query = $db->select()->from($routes->getTableName());
        $query->join($users->getTableName(), 
                $routes->getTableName().'.driver_id = '.$users->getTableName().'.id');
        $query->join($drivers->getTableName(), 
                $users->getTableName().'.id = '.$drivers->getTableName().'.user_id');
//        $query->where($this->user->db_name.'.'.$categoryVat->getTableName().".store_id = ?", $this->selectedStoreId);
//        $query->limit($_GET['iDisplayLength'], $_GET['iDisplayStart']);
//        $query->order($this->user->db_name.'.'.$categoryVat->getTableName().".category ASC");

        $results = $db->fetchAll($query);
        $this->view->results = $results;
        
        
    }
    
    public function newAction()
    {
        $newForm = new Application_Form_Route();
        $this->view->newForm = $newForm;
    }
    
    public function addnewAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $db = Zend_Db_Table::getDefaultAdapter();
        $routes = new Application_Model_Routes();
        
        $newForm = new Application_Form_Route();
        
        if ($this->getRequest()->isPost() && $newForm->isValid($this->_request->getPost())) {
            $dataRoute = array(
                'id' => null,
                'driver_id' => $this->user->id,
                'start' => $this->_request->getPost('start'),
                'finish' => $this->_request->getPost('end'),
                'date' => $this->_request->getPost('routeDate'),
                'passanger' => $this->_request->getPost('passangers')
            );
            
            $db->insert($routes->getTableName(), $dataRoute);
            $this->redirect('/main/active');
        }
    }
    
}

