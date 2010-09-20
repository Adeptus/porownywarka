<?php

class Application_Model_DbTable_Offers extends Application_Model_DatabaseGateway
{
	protected $_name    = 'offers';

    protected $_referenceMap    = array(
        'Categories' => array(
            'columns'           => 'category_id',
            'refTableClass'     => 'Categories',
            'refColumns'        => 'id'
        ),
        'Companies' => array(
            'columns'           => 'company_id',
            'refTableClass'     => 'Companies',
            'refColumns'        => 'id'
        )
    );

}?>
