<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initDoctype() {
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$view->doctype('XHTML1_STRICT');
	}

    protected function _initDatabases(){
    $resource = $this->getPluginResource('multidb');
    $resource->init();

    $db1 = $resource->getDb('db1');
    $db2 = $resource->getDb('db2');

    Zend_Registry::set( 'test' , $db1 );
    Zend_Registry::set( 'default' , $db2 );
    }
/*
	public function _initDbNames()
	{
		$dupa = new Zend_Db_Adapter_Abstract();
		$resource = $this->dupa->getPluginResource('multidb');
		$db1 = $resource->getDb('db1');
		$db2 = $resource->getDb('db2');
		// jeśli ustawiliśmy defaultowe połączenie, wystarczy wpisać
		$deafaultDb = $resource->getDb();
	}
*/
/*
public function _initDbNames()
	{
	    try {
	    $config = array(
	        'host'     => 'localhost',
	        'username' => 'root','password' => 'koza',
	        'dbname'   => 'porownywarka3',
    );
	    $db = Zend_Db::factory('PDO_MYSQL', $config);
	    Zend_Db_Table::setDefaultAdapter($db);
	    $db->query('SET NAMES UTF8');
	    }catch (Exception $e) {
	        echo "Blad polaczenia z baza danych: ".$e->getMessage();
	        exit(0);
	    }
	}*/
}

