<?php

class Application_Form_Seller_Delivery extends Zend_Form {

    protected $_standardElementDecorator = array(
        array('Label'),
        'ViewHelper',
        'errors',
    );

    protected $_buttonElementDecorator = array(
//        'ViewHelper'
    );

    protected $_standardGroupDecorator = array(
        'FormElements',
//        array('HtmlTag', array('tag'=>'br /')),
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

        $this->addElement('text', 'delivery', array(
            'label'      => 'Wpisz numer domyślnej dostawy:',
        ));

        $this->addElement('text', 'addDelivery', array(
            'label' => 'dodaj opis nowej dostawy:',
		));

        $this->addElement('text', 'koszt', array(
            'label' => 'koszt nowej dostawy w zł:',
		));

        $this->addDisplayGroup(
            array('delivery', 'addDelivery', 'koszt'), 'DeliveryGrup',
            array(
                'disableLoadDefaultDecorators' => true,
                'decorators' => $this->_standardGroupDecorator,
                'legend' => 'Opcje dostawy:',
            )
        );


		$this->addElement('submit', 'submit', array(
			'ignore'    => true,
			'label'     => 'Zatwierdz',
		));

	}
}

