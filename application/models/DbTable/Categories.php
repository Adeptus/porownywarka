<?php

class Application_Model_DbTable_Categories extends Application_Model_DatabaseGateway
{
	protected $_name    = 'categories';

    protected $_dependentTables = array('Offers');


}?>
