<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{


    protected function _initAutoload(){
        
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Application',
            'basePath'  => APPLICATION_PATH,
        ));

        Zend_Controller_Action_HelperBroker::addPath(
            APPLICATION_PATH . '/controllers/helpers', 
            'Application_Controller_Helper_');

        return $autoloader;
    }
    
    protected function _initDoctype(){
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }
    
//    protected function _initUserSession()
//    {
//        Zend_Session::setOptions(array('cookie_httponly' => true));
//        return new Zend_Session_Namespace('user');
//    }
    
    protected function _initLogger() 
    {
        $columnMapping = array('priority' => 'priority', 'message' => 'message',
                        'timestamp' => 'timestamp', 'priorityName' => 'priorityName');


        $db = Zend_Db_Table::getDefaultAdapter();

        $writer = new Zend_Log_Writer_Db($db, 'logger', $columnMapping);
        $logger = new Zend_Log($writer);

        Zend_Registry::set('logger', $logger);
        
    }
    
}

//route to app.ini
$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        
//setez config in zend_registry ca sa am acces si in alte controllere
Zend_Registry::set('config', $config);
        
// Instantiate the database and set default db adapter
$db = Zend_Db::factory('PDO_MySQL', array(
        'host'=> $config->database->params->host,
        'username' => $config->database->params->username,
        'password' => $config->database->params->password,
        'dbname' => $config->database->params->dbname,
        'charset'  => $config->database->params->charset));
Zend_Db_Table_Abstract::setDefaultAdapter($db);

// Action Helpers
Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH .'/controllers/helpers');

//initialize layout
Zend_Layout::startMvc(APPLICATION_PATH . '/layouts/scripts');
$view = Zend_Layout::getMvcInstance()->getView();
unset($view);

