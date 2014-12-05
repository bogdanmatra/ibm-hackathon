<?php


class IndexController extends Zend_Controller_Action
{
    
    public function init()
    {
        /* Initialize action controller here */ 
        
        if(Zend_Auth::getInstance()->hasIdentity() !== null){
            $this->view->user = Zend_Auth::getInstance()->getIdentity();
            $this->user = Zend_Auth::getInstance()->getIdentity();
        } else {
            $this->view->user = "";
        }
    }
    
    public function indexAction(){
        
    }

    public function loginAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
       $formLogin = new Application_Form_Login();
//       $this->view->form = $formLogin;
       
       if ($this->getRequest()->isPost() && $formLogin->isValid($this->_request->getPost())) {
            $user = $this->_request->getPost('email');
            $password = $this->_request->getPost('password');

             $adapter = new Zend_Auth_Adapter_DbTable(
                     null,
                     'users',
                     'email',
                     'password'
                     );

            $adapter->setIdentity($user);
            $adapter->setCredential($password);
            Zend_Session::regenerateId();
            $auth = Zend_Auth::getInstance();
            $result = $auth->authenticate($adapter);

            if($result->isValid()){
                $user = $adapter->getResultRowObject();
                $auth->getStorage()->write($user);
                $this->redirect('/main/home'); 
            } else {
                $this->view->errorMessages = "Username and/or Password are incorrect";  
            }
        } else {
            $this->redirect('/index/index');
        } 
//        }
    } 
    
    public function mainAction(){
//        $logger = Zend_Registry::get('logger');
//        $logger->log('ceva', Zend_Log::WARN);
    }
    
//author Stefan Iacob
//function to register the new user in our application
//also creates the secondary db used by each user
//the registration of the user is made as a multiple insert and create db&tables within a mysql transaction
    
    public function registerAction(){
        
        $this->_helper->layout->disableLayout();
        
        $layout = Zend_Layout::getMvcInstance();
        $layout->setLayoutPath(APPLICATION_PATH . '/layouts/scripts');
        $layout->setLayout('alternate');
        
        $form = new Application_Form_Registration();
        $this->view->form = $form;
        
        $owner = new Application_Model_Owner();
        $details = new Application_Model_Details();
//        $account = new Application_Model_Account();
        $db = Zend_Db_Table::getDefaultAdapter();
        
        if ($this->getRequest()->isPost() && $form->isValid($this->_request->getPost())) {
            //luam datele din fiecare din cele 4 subform-uri ale formularului de inregistrare
            $step1 = $this->_request->getPost("step1");
            $step2 = $this->_request->getPost("step2");

            $lang = Zend_Registry::get('Zend_Lang'); 
            $db_name = 'inco_dashboard_'.$step1['username'];

            $owner_data = array(
                'local_id' => null,
                'email' => $step1['email'],
                'username' => $step1['username'],
                'password' => $step1['password'],
                'photo' => 'images/user/default.jpg',
                'privilage' => 'ADMINISTRATOR',
                'lang' => $lang,
                'db_name' => $db_name
            );
            $db->insert($owner->getTableName(), $owner_data);
            $owner_id = $db->lastInsertId($owner->getTableName(), 'local_id');
            $details_data = array(
                'local_id' => null,
                'owner_id' => $owner_id,
                'last_name' => $step2['familyName'],
                'first_name' => $step2['givenName']
            );

            $sql = 'CREATE DATABASE '.$db_name;
            $sql2 = "CREATE TABLE `$db_name`.`store` (
                    `local_id` int(11) unsigned NOT NULL auto_increment,
                    `owner_id` int(11) unsigned NOT NULL,
                    `store_name` varchar(255) NOT NULL,
                    `store_logo` varchar(255) NOT NULL,
                    `store_url` varchar(255) NOT NULL,
                    PRIMARY KEY  (`local_id`)
                  )";

            $db->beginTransaction();
            try{
                $db->insert($details->getTableName(), $details_data);
                $db->query($sql);
                $db->query($sql2);
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                $this->view->errorMessages = "There was a problem with your registration: " . $e->getMessage() . "\n";
            }
           $this->redirect('/');
        } else {
            $logger = Zend_Registry::get('logger');
            $logger->log('Register Action: '.$e, Zend_Log::ERR); 
        } 
    }
    
    
    

    public function logoutAction(){
        Zend_Session::destroy(true);
        $this->redirect('/index/index');
    }
       
}


