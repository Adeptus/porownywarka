<?php

class Application_Model_DbTable_Delivery extends Application_Model_DatabaseGateway
{
	protected $_name    = 'delivery';

	public function getDeliveryById($id) {
        $row = $this->fetchRow('id='.$id);
		if (!$row) {
			return null;
		}
		return $row->toarray();
	}

	public function getDeliveryByName($nazwa) {
        $select = $this->select();
        $select->where('dostawa= ?', $nazwa);
        $row = $this->fetchRow($select);
		if (!$row) {
			return null;
		}
		return $row->toarray();
	}

	public function getDeliveryByCompanyIdAndNumber($id, $number) {
        $select = $this->select();
        $select->where("id_firmy = ?", $id)
               ->where("numer = ?"   , $number);
        $row = $this->fetchRow($select);
		if (!$row) {
			return null;
		}
		return $row;
	}

	public function getDeliveriesByCompanyId($id) {
        $select = $this->select();
        $select->where('id_firmy= ?', $id)
               ->order("numer");
        $rows = $this->fetchAll($select);
		if (!$rows) {
			return null;
		}
		return $rows;
	}

	public function addDelivery($id = null, $id_firmy, $numer, $dostawa, $koszt = null) {
        $row = $this->createRow();
        if ($row) {
            $row->id            = $id;
            $row->id_firmy      = $id_firmy;
            $row->numer         = $numer;
            $row->dostawa       = $dostawa;
            $row->koszt         = $koszt;
            $row->save();
            return True;
        }   else    {
            return 'Nie mozna dodac dostawy. Bład Bazy Danych!';
        }
	}

	public function updateDelivery($id, $dostewa, $koszt = null) {
		$data = array(
            'id'            => $id,
            'dostawa'       => $dostawa,
            'koszt'         => $koszt,
		);
		$this->update($data, 'id='.(int)$id);
	}

	public function deleteDelivery($id) {
		$this->delete('id='.(int)$id);
	}

}?>
