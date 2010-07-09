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

		$this->addElement('text', 'Cale', array(
			'value'      =>  $cale,
			'label'      =>	'Podaj wielkosc matryce w calach:',
			'required'   =>   true,
			'filters'    =>   array('StringTrim'),
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

