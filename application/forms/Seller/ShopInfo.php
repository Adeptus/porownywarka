<?php

class Application_Form_Seller_ShopInfo extends Zend_Form {

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

		$this->addElement('text', 'nazwa', array(
			'required'   =>   true,
            'label' => 'nazwa:',
		));

        $this->addDisplayGroup(
            array('nazwa'), 'firma',
            array(
                'disableLoadDefaultDecorators' => true,
                'decorators' => $this->_standardGroupDecorator,
                'legend' => 'Firma:',
            )
        );
        
        $this->addElement('text', 'adres', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'adres:',
        ));

        $this->addElement('text', 'kod', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'kod pocztowy:',
        ));

        $this->addElement('text', 'miasto', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'miejscowowść:',
        ));

        $this->addDisplayGroup(
            array('adres', 'kod', 'miasto'), 'lokalizacja',
            array(
                'disableLoadDefaultDecorators' => true,
                'decorators' => $this->_standardGroupDecorator,
                'legend' => 'Dane adresowe:',
            )
        );

        $this->addElement('text', 'mail', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'e-mail:',
        ));

        $this->addElement('text', 'tel', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'telefon:',
        ));

        $this->addDisplayGroup(
            array('mail', 'tel'), 'kontakt',
            array(
                'disableLoadDefaultDecorators' => true,
                'decorators' => $this->_standardGroupDecorator,
                'legend' => 'Dane kontaktowe:',
            )
        );


		$this->addElement('submit', 'submit', array(
			'ignore'    => true,
			'label'     => 'Zatwierdz dane',
		));

	}
}

