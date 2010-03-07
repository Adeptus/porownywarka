<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initDoctype() {
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$view->doctype('XHTML1_STRICT');
	}

public function _initDbNames()
	{
	    try {
	    $config = array(
	        'host'     => 'sql109.xtreemhost.com',
	        'username' => 'xth_5188134','password' => 'koza1401',
	        'dbname'   => 'xth_5188134_porownywarka',
    );
	    $db = Zend_Db::factory('PDO_MYSQL', $config);
	    Zend_Db_Table::setDefaultAdapter($db);
	    $db->query('SET NAMES UTF8');
	    }catch (Exception $e) {
	        echo "Blad polaczenia z baza danych: ".$e->getMessage();
	        exit(0);
	    }
	}
}

