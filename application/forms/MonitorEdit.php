<?php

class Application_Form_MonitorEdit extends Zend_Form {

	public function init() {
		$this->setMethod('post');

		$this->addElement('text', 'id', array(
			'label'      =>	'Podaj id przedmiotu:',
			'required'   =>   true,
            'validators' =>  array('int')
		));

        Application_Form_MonitorAdd::init();
    }
}

