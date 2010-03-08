<?php

class Application_Form_MonitorEdit extends Zend_Form {

	public function init() {
		$this->setMethod('post');

		$this->addElement('text', 'id', array(
			'label'      =>	'Podaj id przedmiotu:',
			'required'   =>   true,
			'filters'    =>   array('StringTrim'),
		));
		
		$this->addElement('text', 'marka', array(
			'label'      =>	'Podaj nazwe producenta:',
			'required'   =>   true,
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('text', 'nazwa', array(
			'label'      =>	'Podaj nazwe produktu:',
			'required'   =>   true,
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('text', 'Cale', array(
			'label'      =>	'Podaj wielkosc matryce w calach:',
			'required'   =>   true,
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('text', 'Jasnosc', array(
			'label'      =>	'Podaj Jasnosc(cd/m2):',
			'required'   =>   true,
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('text', 'Reakcja', array(
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
			'label'     => 'Edytuj Przedmiot',
		));

	}
}
