<?php

class Application_Form_SearchByParameters extends Zend_Form {

    protected $_standardElementDecorator = array(
        array('Label'),
        'ViewHelper',
        'errors',
    );

    protected $_buttonElementDecorator = array(
        'ViewHelper'
    );

    protected $_standardGroupDecorator = array(
        'FormElements',
//        array('HtmlTag', array('tag'=>'ol')),
        'Fieldset'
    );

    protected $_buttonGroupDecorator = array(
        'FormElements',
//        'Fieldset'
    );

    public function __construct($options = null) {
        parent::__construct($options);

        $this->setAttrib('accept-charset', 'UTF-8');
        $this->setDecorators(array(
            'FormElements',
            'Form'
        ));
    }

	public function init() {
		$this->setMethod('post');

        
        $this->addElement('text', 'CaleOd', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'Od:',
            'style'    => 'width: 4em; height: 1,5em;',
            'validators' =>  array(array('regex', true, array('/^[0-9]{2}(\,|\.)?[0-9]?$/'))),
            'ErrorMessages' => array("tylko cyfry"),
        ));

        $this->addElement('text', 'CaleDo', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'Do:',
            'validators' =>  array(array('regex', true, array('/^[0-9]{2}(\,|\.)?[0-9]?$/'))),
            'ErrorMessages' => array("tylko cyfry"),
            'style'    => 'width: 4em; height: 1,5em;',
        ));

        $this->addDisplayGroup(
            array('CaleOd', 'CaleDo'), 'Cale',
            array(
                'disableLoadDefaultDecorators' => true,
                'decorators' => $this->_standardGroupDecorator,
                'legend' => 'Cale:',
            )
        );

		$this->addElement('text', 'JasnoscOd', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'Od:',
            'validators' =>  array('int'),
            'ErrorMessages' => array("tylko cyfry"),
            'style'    => 'width: 4em; height: 1,5em;',
		));

		$this->addElement('text', 'JasnoscDo', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'Do:',
            'validators' =>  array('int'),
            'ErrorMessages' => array("tylko cyfry"),
            'style'    => 'width: 4em; height: 1,5em;',
		));

        $this->addDisplayGroup(
            array('JasnoscOd', 'JasnoscDo'), 'Jasnosc',
            array(
                'disableLoadDefaultDecorators' => true,
                'decorators' => $this->_standardGroupDecorator,
                'legend' => 'Jasnosc:',
            )
        );

		$this->addElement('submit', 'submit', array(
            'decorators'=> $this->_buttonElementDecorator,
			'ignore'    => true,
			'label'     => 'Wyszukaj',
            'style'    => 'width: 17em; height: 1,5em;',
		));
    }
}
