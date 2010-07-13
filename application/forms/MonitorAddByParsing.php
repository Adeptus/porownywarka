<?php

class Application_Form_MonitorAddByParsing extends Zend_Form {	

	public function init() {
		$this->setMethod('post');
		
        $this->addElement('select', 'producent', array(
            'label'      => 'Wybierz producenta monitora:',
            'required'   => true,
            'multioptions'   => array(
                            'samsung'  => 'Samsung',
                            'nieznany' => 'Nieznany'),

        ));

		$this->addElement('text', 'nazwa', array(
			'label'      =>	'Podaj nazwe monitora:',
			'required'   => true,
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('submit', 'submit', array(
			'ignore'    => true,
			'label'     => 'wyszukaj przedmiot',
		));

	}
}

