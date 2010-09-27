<?php

class Application_Model_DbTable_Offers extends Application_Model_DatabaseGateway
{
	protected $_name    = 'offers';

    protected $_referenceMap    = array(
        'categories' => array(
            'columns'           => 'category_name',
            'refTableClass'     => 'categories',
            'refColumns'        => 'name'
        ),
        'companies' => array(
            'columns'           => 'company_id',
            'refTableClass'     => 'companies',
            'refColumns'        => 'id'
        )
    );

    public function addoffer($id =null, $price, $promotion = null, $delivery = null, $description = null,  $link = null, $state = null, $pricewholesale = null, $installment =null, $company_id, $category_name, $item_producer, $item_name) {
        $row = $this->createRow();
            if ($row) {
                $row->id             = $id;
                $row->price          = $price;
                $row->promotion      = $promotion;
                $row->delivery       = $delivery;
                $row->description    = $description;
                $row->link           = $link;
                $row->state          = $state;
                $row->pricewholesale = $pricewholesale;
                $row->installment    = $installment;
                $row->company_id     = $company_id;
                $row->category_name  = $category_name;
                $row->item_producer  = $item_producer;
                $row->item_name      = $item_name;

                $row->save();
                return True;
            }   else    {
                return $error = 'Nie mozna dodac oferty. Bład Bazy Danych!';
            }
    }

    public function getAllOffersFromCategoryCompanyId($category, $company) {
        $select = $this->select()
                       ->where('company_id = ?', $company)
                       ->where('category_name = ?', $category);
        return $this->fetchAll($select);
    }

    public function getAllOffersCompanyById($companyId) {
        $select = $this->select()
                       ->where('company_id = ?', $companyId);
        return $this->fetchAll($select);               
    }

	public function deleteOffer($id) {
		$this->delete('id='.(int)$id);
	}

}?>
