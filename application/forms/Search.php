<?php

class Application_Form_Search extends Zend_Form {

	public function init() {
		$this->setMethod('post');

		$this->addElement('text', 'id', array(
			'label'      =>	'Znajdz po id:',
            'validators' =>  array('int')
		));
		
		$this->addElement('text', 'nazwa', array(
			'label'      =>	'Znajdz po nazwie:',
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('submit', 'submit', array(
			'ignore'    => true,
			'label'     => 'Znajdz',
		));

	}
}

