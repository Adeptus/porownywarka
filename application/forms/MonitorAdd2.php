<?php

class Application_Form_MonitorAdd2 extends Zend_Form {	

	public function init() {
		$this->setMethod('post');
		
		$this->addElement('text', 'url', array(
			'label'      =>	'Podaj url z przedmiotem:',
			'filters'    =>   array('StringTrim'),
		));

	/*	$this->addElement('text', 'nazwa', array(
			'label'      =>	'Podaj nazwe produktu:',
			'required'   =>   true,
			'filters'    =>   array('StringTrim'),
		));
*/
		$this->addElement('submit', 'submit1', array(
			'ignore'    => true,
			'label'     => 'wyszukaj przedmiot',
		));

	}
}

