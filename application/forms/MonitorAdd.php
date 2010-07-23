<?php

class Application_Form_MonitorAdd extends Zend_Form {

	public function init($marka = null, $nazwa = null, $cale = null, $jasnosc = null, $reakcja = null) {
		$this->setMethod('post');
		
		$this->addElement('text', 'marka', array(
			'value'      =>  $marka,
			'label'      =>	'Podaj nazwe producenta:',
			'required'   =>   true,
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('text', 'nazwa', array(
			'value'      =>  $nazwa,
			'label'      =>	'Podaj nazwe produktu:',
			'required'   =>   true,
			'filters'    =>   array('StringTrim'),
		));
 $name = new Zend_Form_Element_Text('Cale');

		$this->addElement('text', 'Cale', array(
			'value'      =>  $cale,
			'label'      =>	'Podaj wielkosc matryce w calach:',
			'required'   =>   true,
            'validators' =>  array('alnum', array('regex', false, array('/^[0-9][0-9]$/'))),
			'filters'    =>   array('StringTrim'),
            'ErrorMessages' => array("Wartos moze skladac sie tylko z dwuch cyfr."),
		));

		$this->addElement('text', 'Jasnosc', array(
			'value'      =>  $jasnosc,
			'label'      =>	'Podaj Jasnosc(cd/m2):',
			'required'   =>   true,
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('text', 'Reakcja', array(
			'value'      =>  $reakcja,
			'label'      =>	'Podaj czas reakcji matrycy(sek):',
			'required'   =>   true,
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('text', 'Kontrast', array(
			'value'      =>  $kontrast,
			'label'      =>	'Podaj kontrast:',
			'required'   =>   true,
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('text', 'Rozdzielczosc', array(
			'value'      =>  $rozdzielczosc,
			'label'      =>	'Podaj rozdzielczosc:',
			'required'   =>   true,
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('text', 'Katy', array(
			'value'      =>  $katy,
			'label'      =>	'Podaj katy widocznosc (poziomo/pionowo):',
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('text', 'Kolor', array(
			'value'      =>  $kolor,
			'label'      =>	'Podaj kolor obrazu:',
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('text', 'Pobor', array(
			'value'      =>  $pobor,
			'label'      =>	'Podaj pobor prądu(włączony):',
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('text', 'Czuwanie', array(
			'value'      =>  $czuwanie,
			'label'      =>	'Podaj pobor prądu(czuwanie):',
			'filters'    =>   array('StringTrim'),
		));
	
		$this->addElement('text', 'Waga', array(
			'value'      =>  $waga,
			'label'      =>	'Podaj wage monitora:',
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('captcha', 'captcha', array(
			'label'      => 'Wprowadz 5 ponizszych liter:',
			'required'   => true,
			'captcha'    => array(
				'captcha'  =>  'Figlet',
				'wordLen'  =>  5,
				'timeout'  =>  300
			)
		));

		$this->addElement('submit', 'submit', array(
			'ignore'    => true,
			'label'     => 'Dodaj Przedmiot',
		));

	}
}

