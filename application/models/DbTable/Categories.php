<?php

class Application_Model_DbTable_Categories extends Application_Model_DatabaseGateway
{
	protected $_name    = 'categories';

    protected $_dependentTables = array('Offers');

    public function checkCategoryExist($category) {
        $select = $this->select()
                       ->where('name = ?', $category)
                       ->orwhere('id = ?', $category);
        $row = $this->fetchRow($select);
        if(!$row) {
            return null;
        } else return true;
    }

    public function getAllRowFromCategory($category) {
        $select = $this->select()
                       ->where('name = ?', $category);
        $row = $this->fetchRow($select);
        return $row->toarray();
    }

    public function updateNumberOffersInCategory($numberOffers, $id) {
        $data = array(		
        	'number_offers' => $numberOffers
		);
		$this->update($data, 'id='.(int)$id);
	}
    
}?>
