<?php

class Application_Model_DbTable_Monitors extends Application_Model_DatabaseGateway
{
	protected $_name    = 'monitory';

    public function getFieldsNames() {
        return array('Cale', 'Jasnosc', 'Reakcja', 'Kontrast', 'Rozdzielczosc');
    }

    public function getFieldsDescriptions() {
        return array('Cale'          => "<b>Przekątna</b><br>Przekątna ekranu podawana w calach",
                     'Jasnosc'       => "<b>Jasność</b><br>Podawana w kandelach na metr kwadratowy (cd/m2) określa maksymalną światłość którą emituje<br> ekran wyświetlający czystą biel",
                     'Reakcja'       => "<b>Czas reakcji</b><br>Średni czas zapalenia i zgaszenia piksela. Wpływa na jakość wyświetlania dynamicznych scen.<br> W monitorach o większym czasie reakcji może pojawiać się tzw. smużenie.",
                     'Kontrast'      => "<b>Kontrast</b><br>Stosunek jasności maksymalnej do minimalnej. Bardzo ważny parametr monitora.<br> Im większy kontrast tym lepsze odzworowanie czerni i dobre odwzorowanie <br>szczegółów w ciemnych partiach obrazu.",
                     'Rozdzielczosc' => "<b>Rozdzielczość</b><br>Ilość pikseli na ekranie, podawana w formacie szerokość na wysokość.<br> Większa rozdzielczość pozwala na wyświetlenie bardziej szczegółowych obrazów.");
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
             ->from(array('m' => 'monitory'), 'marka');

        $select = $this->select()->union(array($selectA, $selectA));

        $rows = $this->fetchAll($select);
		if (!$rows) {
			return null;
		}
		return $rows->toarray();
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

    public function getIdsByParameters($parameter, $valueMin = null, $valueMax = null) {
        if (($valueMin != null) && ($valueMax == null)) {
            $select = $this->select()
                ->from ('monitory')
                ->where($parameter.'>= ?', $valueMin)
                ->order('id');
            $monitorsIdsTable = $this->fetchall($select);
            return $this->changeMonitorsIdsTableToTableWithId($monitorsIdsTable);
        } else if (($valueMin == null) && ($valueMax != null)) {
            $select = $this->select()
                ->from ('monitory')
                ->where($parameter.'<= ?', $valueMax)
                ->order('id');
            $monitorsIdsTable = $this->fetchall($select);
            return $this->changeMonitorsIdsTableToTableWithId($monitorsIdsTable);
        } else if (($valueMin != null) && ($valueMax != null)) { 
            $select = $this->select()
                ->from ('monitory')
                ->where($parameter.'>= ?', $valueMin)
                ->where($parameter.'<= ?', $valueMax)
                ->order('id');
            $monitorsIdsTable = $this->fetchall($select);
            return $this->changeMonitorsIdsTableToTableWithId($monitorsIdsTable);
        } else {
            return array();
        }
    }
    
    private function changeMonitorsIdsTableToTableWithId($monitorsIdsTable) {
        if (($monitorsIdsTable[0] != null)) {
            foreach ($monitorsIdsTable as $monitorId) {
                $tabelaWithId[] = $monitorId['id'];
            }	
            return $tabelaWithId;
        } else {
            return null;
        }
    }
}?>
