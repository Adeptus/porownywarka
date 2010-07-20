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


/*		$data = array(
			'id'    		 => $id,
			'marka'   		 => $marka,
			'nazwa'  		 => $nazwa,
			'Cale'    		 => $cale,
			'Jasnosc' 		 => $jasnosc,
			'Reakcja' 		 => $reakcja,
			'Kontrast'   	 => $kontrast,
			'Rozdzielczosc'  => $rozdzielczosc,
			'Katy' 			 => $katy,
			'Kolor'			 => $kolor,
			'Pobor'   		 => $pobor,
			'Czuwanie'    	 => $czuwanie,
			'Waga'           => $waga,
		);
		$this->insert($data);
*/	}

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
	
}
?>
