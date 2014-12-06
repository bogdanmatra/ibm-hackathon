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
       
       if ($this->getRequest()->isPost()){ 
            foreach($this->_request->getPost('dataPost') as $dataArray){
                $name = $dataArray['name'];
                $formDataForValidation["$name"] = $dataArray['value']; 
                
            }
            
            if($formLogin->isValid($formDataForValidation)){
                $user = $formDataForValidation['email'];
                $password = $formDataForValidation['password'];

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
                    $this->_helper->json(0);
                } else {
                    $this->_helper->json(1);
                }
            } else {
                $this->_helper->json(1);
            }
       }
    } 
    
    public function mainAction(){
//        $logger = Zend_Registry::get('logger');
//        $logger->log('ceva', Zend_Log::WARN);
    }
    
//author Stefan Iacob
//function to register the new user in our application
    
    public function registerAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $db = Zend_Db_Table::getDefaultAdapter();
        $users = new Application_Model_Users();
        
        $registerForm = new Application_Form_Registration();
        
        if($this->_request->isPost()){
            foreach($this->_request->getPost('dataPost') as $dataArray){
                $name = $dataArray['name'];
                $formDataForValidation["$name"] = $dataArray['value']; 
                
            }
            if($formDataForValidation['driverCheck'] === "1"){
                $carModel = $registerForm->getElement('carModel');
                $carModel->setRequired(true)->addErrorMessage('Required');
                
                $carMake = $registerForm->getElement('carMake');
                $carMake->setRequired(true)->addErrorMessage('Required');
                
                $driverLicense = $registerForm->getElement('driverLicense');
                $driverLicense->setRequired(true)->addErrorMessage('Required');
            }
            if($registerForm->isValid($formDataForValidation)){
                
                $userDataInsert = array(
                    'id' => null,
                    'email' => $formDataForValidation['emailRegister'],
                    'password' => $formDataForValidation['passwordRegister'],
                    'last_name' => $formDataForValidation['lastName'],
                    'first_name' => $formDataForValidation['firstName'],
                    'driver_flag' => $formDataForValidation['driverCheck'],
                    'telephone' => $formDataForValidation['telephone']
                );
                
                try {
                    $db->insert($users->getTableName(), $userDataInsert);
                    $last_id = $users->getAdapter()->lastInsertId();
                } catch (Zend_Exception $e) {
                    $this->redirect('/error/error');
                }
                
                if($formDataForValidation['driverCheck']){ //if the user is a driver => need to update driver data
                    $driver = new Application_Model_Driver();
                    $driverDataInsert = array(
                        'id' => null,
                        'user_id' => $last_id,
                        'make' => $formDataForValidation['carMake'],
                        'model' => $formDataForValidation['carModel'],
                        'license' => $formDataForValidation['driverLicense'],
                        'completed' => 0
                    );
                    try {
                        $db->insert($driver->getTableName(), $driverDataInsert);
                    } catch (Zend_Exception $e) {
                        $this->redirect('/error/error');
                    }
                }
                $this->_helper->json(0);
            } else {
                $errorMessages = $registerForm->getMessages();
                $this->_helper->json($errorMessages);
            }
            
        }
    }
    
    
    

    public function logoutAction(){
        Zend_Session::destroy(true);
        $this->redirect('/main/home');
    }
       
}


