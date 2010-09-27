<?php

class Application_Form_Seller_AddParametersByXml extends Zend_Form {

    protected $_standardElementDecorator = array(
        array('Label'),
        'ViewHelper',
        'errors',
    );

    protected $_standardGroupDecorator = array(
        'FormElements',
        'Fieldset'
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

        $options = array(
            "$this->category[1]['name']"  => "$this->category[2]['name']",
            '2'  =>'B',
            '3'  =>'C',
            '4'  =>'D',
            '5'  =>'E',
            '6'  =>'F',
            '7'  =>'G',
            '8'  =>'H',
            '9'  =>'I',
            '10' =>'J',
            '11' =>'K',
            '12' =>'L',
            '13' =>'M',
            '14' =>'N',
            '15' =>'O'
        );

        $this->addElement('select', 'itemProducer', array(
            'label'      => 'Podaj kolumną z nazwą producentów:',
			'required'   =>   true,
            'MultiOptions' => $options,
        ));

		$this->addElement('select', 'itemName', array(
			'label'      =>	'Podaj kolumną z nazwą przedmiów:',
			'required'   =>   true,
            'MultiOptions' => $options,
		));

		$this->addElement('select', 'itemPrice', array(
			'label'      =>	'Podaj kolumną z ceną:',
			'required'   =>   true,
            'MultiOptions' => $options,
		));

        $this->addDisplayGroup(
            array('itemProducer', 'itemName', 'itemPrice'), 'OfferParameters',
            array(
                'disableLoadDefaultDecorators' => true,
                'decorators' => $this->_standardGroupDecorator,
                'legend' => 'Wymagane pola arkusza:',
            )
        );
    }
}
