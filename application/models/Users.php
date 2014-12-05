<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Stefan Iacob
 */
class Application_Model_Users extends Zend_Db_Table {
    protected $_name = "users"; //table name from db
    protected $_primary = "id"; //table pk
 
    public function getTableName()
    {
        return $this->_name;
    }
}
