<?php

class Application_Model_DatabaseGateway extends Zend_Db_Table_Abstract
{
	 public function setupDatabaseTest()
	{
		$this->_db = Zend_Registry::get( 'test');
	}
}
