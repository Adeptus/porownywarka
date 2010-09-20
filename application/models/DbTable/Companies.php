<?php

class Application_Model_DbTable_Companies extends Application_Model_DatabaseGateway
{
	protected $_name    = 'companies';

    protected $_dependentTables = array('Offers');

	public function getCompanyById($id) {
        $row = $this->fetchRow('id='.$id);
		if (!$row) {
			return null;
		}
		return $row->toarray();
	}

	public function getCompanyByName($nazwa) {
        $select = $this->select();
        $select->where('nazwa= ?', $nazwa);
        $row = $this->fetchRow($select);
		if (!$row) {
			return null;
		}
		return $row->toarray();
	}

	public function addCompany($id = null, $nazwa, $adres = null, $kod = null, $miasto = null, $mail = null, $tel = null, $dostawa = null, $wspolrzedne = null) {
        if($this->getCompanyByName($nazwa) === null) {        
            $row = $this->createRow();
            if ($row) {
                $row->id            = $id;
                $row->nazwa         = $nazwa;
                $row->adres         = $adres;
                $row->kod           = $kod;
                $row->miasto        = $miasto;
                $row->mail          = $mail;
                $row->tel           = $tel;
                $row->dostawa       = $dodefaultdeliverystawa;
                $row->wspolrzedne   = $wspolrzedne;
                $row->save();
                return True;
            }   else    {
                return 'Nie mozna dodac firmy. Bład Bazy Danych!';
            }
        } else {
            return 'Firma o takiej nazwie juz istnieje';
        }
	}

	public function updateCompany($id, $nazwa, $adres = null, $kod = null, $miasto = null, $mail = null, $tel = null, $wspolrzedne = null) {
		$data = array(
            'id'            => $id,
            'nazwa'         => $nazwa,
            'adres'         => $adres,
            'kod'           => $kod,
            'miasto'        => $miasto,
            'mail'          => $mail,
            'tel'           => $tel,
            'wspolrzedne'   => $wspolrzedne
		);
		$this->update($data, 'id='.(int)$id);
	}

	public function updateCompanyDelivery($id, $idDelivery) {
		$data = array(
            'id'            => $id,
            'dostawa'       => $idDelivery
		);
		$this->update($data, 'id='.(int)$id);
	}

}?>
