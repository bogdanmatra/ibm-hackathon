<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Model_Driver extends Zend_Db_Table {
    protected $_name = "driver_details"; //table name from db
    protected $_primary = "id"; //table pk
 
    public function getTableName()
    {
        return $this->_name;
    }
}