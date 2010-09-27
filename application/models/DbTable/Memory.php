<?php

class Application_Model_DbTable_Memory extends Application_Model_DatabaseGateway
{
	protected $_name    = 'memory';

    public function getFieldsNames() {
        return array('zlacze', 'predkosc', 'pojemnosc');
    }

    public function getFieldsDescriptions() {
        return array('pojemnosc'          => "<b>Pojemność</b><br>Pojemność pamięci podana w megabajtach lub gigabajtach. <br>Im większa pojemność tym więcej danych się w nim zmieści.",
                     'predkosc'       => "<b>Predkość</b><br>Predkosc zapisu danych.",
                     'zlacze'       => "<b>Złącze</b><br>Wersja interfejsu USB. W tej chwili wszystkie nowoczesne urządzenia<br> posiadają interfejs USB 2.0 (High Speed)");
    }

	public function getMonitorById($id) {
        $row = $this->fetchRow('id='.$id);
		if (!$row) {
			return null;
		}
		return $row;
	}

	public function getMonitorByName($nazwa) {
        $select = $this->select();
        $select->where('nazwa= ?', $nazwa);
        $row = $this->fetchRow($select);
		if (!$row) {
			return null;
		}
		return $row;
	}

	public function getAllProducers() {
        $selectA = $this->select()
             ->from(array('m' => 'memory'), 'marka');

        $select = $this->select()->union(array($selectA, $selectA));

        $rows = $this->fetchAll($select);
		if (!$rows) {
			return null;
		}
		return $rows->toarray();
    }

}
