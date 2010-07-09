<?php

class Application_Form_MonitorDelete extends Zend_Form {

	public function init() {
		$this->setMethod('post');

		$this->addElement('text', 'id', array(
			'label'      =>	'Podaj id przedmiotu:',
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
			'label'     => 'Usun Przedmiot',
		));

	}
}

