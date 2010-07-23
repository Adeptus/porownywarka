<?php

class Application_Model_DbTable_Monitors extends Application_Model_DatabaseGateway
{
	protected $_name    = 'monitory';

	public function getMonitorById($id) {
        $row = $this->fetchRow('id='.$id);
		if (!$row) {
			return null;
		}
		return $row->toArray();
	}

	public function getMonitorByName($nazwa) {
        $select = $this->select();
        $select->where('nazwa= ?', $nazwa);
        $row = $this->fetchRow($select);
		if (!$row) {
			return null;
		}
		return $row->toArray();
	}

	public function addMonitor($id = null, $marka, $nazwa, $cale, $jasnosc, $reakcja, $kontrast, $rozdzielczosc, $katy = null, $kolor = null, $pobor = null, $czuwanie = null, $waga = null) {
        if($this->getMonitorByName($nazwa) === null) {        
            $row = $this->createRow();
            if ($row) {
                $row->id            = $id;
                $row->marka         = $marka;
                $row->nazwa         = $nazwa;
                $row->Cale          = $cale;
                $row->Jasnosc       = $jasnosc;
                $row->Reakcja       = $reakcja;
                $row->Kontrast      = $kontrast;
                $row->Rozdzielczosc = $rozdzielczosc;
                $row->Katy          = $katy;
                $row->Kolor         = $kolor;
                $row->Pobor         = $pobor;
                $row->Czuwanie      = $czuwanie;
                $row->Waga          = $waga;
                $row->save();
                return True;
            }   else    {
                return 'Nie mozna dodac monitora. Bład Bazy Danych!';
            }
        } else {
            return 'Monitor o takiej nazwie juz istnieje';
        }
	}

	public function updateMonitor($id, $marka, $nazwa, $cale, $jasnosc, $reakcja, $kontrast, $rozdzielczosc, $katy = null, $kolor = null, $pobor = null, $czuwanie = null, $waga = null) {
		$data = array(
			'marka' 		 => $marka,
			'nazwa'  		 => $nazwa,
			'Cale'   		 => $cale,
			'Jasnosc'		 => $jasnosc,
			'Reakcja'		 => $reakcja,
			'Kontrast'   	 => $kontrast,
			'Rozdzielczosc'  => $rozdzielczosc,
			'Katy' 			 => $katy,
			'Kolor'			 => $kolor,
			'Pobor'   		 => $pobor,
			'Czuwanie'    	 => $czuwanie,
			'Waga'           => $waga,
		);
		$this->update($data, 'id='.(int)$id);
	}

	public function deleteMonitor($id) {
		$this->delete('id='.(int)$id);
	}

    //Wyszukiwanie id po parametrach:

    public function getIdsByParameters($parameter, $value_parameter, $option = null, $value_parameter2 = null) {
        if ($option === 'min') {
            $select = $this->select()
                ->from ('monitory', 'id')
                ->where($parameter.'>= ?', $value_parameter)
                ->order('id');
            $monitorsIdsTable = $this->fetchall($select);
            return $tabelaWithId = $this->changeMonitorsIdsTableToTableWithId($monitorsIdsTable);
        } else if($option === "max") {
            $select = $this->select()
                ->from ('monitory', 'id')
                ->where($parameter.'<= ?', $value_parameter)
                ->order('id');
            $monitorsIdsTable = $this->fetchall($select);
            return $tabelaWithId = $this->changeMonitorsIdsTableToTableWithId($monitorsIdsTable);
        } else if ($option === "between") { 
            $select = $this->select()
                ->from ('monitory', 'id')
                ->where($parameter.'>= ?', $value_parameter)
                ->where($parameter.'<= ?', $value_parameter2)
                ->order('id');
            $monitorsIdsTable = $this->fetchall($select);
            return $tabelaWithId = $this->changeMonitorsIdsTableToTableWithId($monitorsIdsTable);
        } else {
            $select = $this->select()
                ->from ('monitory', 'id')
                ->where($parameter.'= ?', $value_parameter)
                ->order('id');
            $monitorsIdsTable = $this->fetchall($select);
            return $tabelaWithId = $this->changeMonitorsIdsTableToTableWithId($monitorsIdsTable);
        }
    }
    
    private function changeMonitorsIdsTableToTableWithId($monitorsIdsTable) {
        foreach ($monitorsIdsTable as $monitorId) {
            $tabelaWithId[] = $monitorId['id'];
        }	
        return $tabelaWithId;
    }
}?>
