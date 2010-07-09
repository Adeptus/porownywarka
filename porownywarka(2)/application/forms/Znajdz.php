<?php

class Application_Form_Znajdz extends Zend_Form {

	public function init() {
		$this->setMethod('post');

		$this->addElement("checkbox", "ddd", array(
		'disable' => ($this->element['id'])//"this.form.elements['id'].disabled = !this.checked");
		));

		$this->addElement('text', 'id', array(
			'label'      =>	'Znajdz po id:',
			'filters'    =>   array('StringTrim'),
		));
		
		$this->addElement('text', 'nazwa', array(
			'label'      =>	'Znajdz po nazwie:',
//			'required'   =>   true,
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('submit', 'submit', array(
			'ignore'    => true,
			'label'     => 'Znajdz',
		));

	}
}

