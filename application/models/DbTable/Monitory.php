<?php

class Application_Model_DbTable_Monitory extends Application_Model_DatabaseGateway
{
	protected $_name    = 'monitory';

	public function getMonitor($id) {
		$id = (int)$id;
		$row = $this->fetchRow('id='.$id);
		if (!$row) {
			return null;
		}
		return $row->toArray();
	}

	public function get2Monitor($nazwa) {
		$nazwa = (float)$nazwa;
		$row = $this->fetchRow('nazwa='.$nazwa);
		if (!$row) {
			return null;
		}
		return $row->toArray();
	}

	public function addMonitor($id = null, $marka, $nazwa, $cale, $jasnosc, $reakcja) {
		$data = array(
			'id'   => $id,
			'marka'   => $marka,
			'nazwa'   => $nazwa,
			'Cale'    => $cale,
			'Jasnosc' => $jasnosc,
			'Reakcja' => $reakcja
		);
		$this->insert($data);
	}

	public function updateMonitor($id, $marka, $nazwa, $cale, $jasnosc, $reakcja) {
		$data = array(
			'marka'   => $marka,
			'nazwa'   => $nazwa,
			'Cale'    => $cale,
			'Jasnosc' => $jasnosc,
			'Reakcja' => $reakcja
		);
		$this->update($data, 'id='.(int)$id);
	}

	public function deleteMonitor($id) {
		$this->delete('id='.(int)$id);
	}
	
}
?>
