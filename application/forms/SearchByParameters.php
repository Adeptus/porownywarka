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

        $this->addElement('text', 'ReakcjaOd', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'Od:',
            'style'    => 'width: 4em; height: 1,5em;',
            'validators' =>  array('int'),
            'ErrorMessages' => array("tylko cyfry"),
        ));

        $this->addElement('text', 'ReakcjaDo', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'Do:',
            'validators' =>  array('int'),
            'ErrorMessages' => array("tylko cyfry"),
            'style'    => 'width: 4em; height: 1,5em;',
        ));

        $this->addDisplayGroup(
            array('ReakcjaOd', 'ReakcjaDo'), 'Reakcja',
            array(
                'disableLoadDefaultDecorators' => true,
                'decorators' => $this->_standardGroupDecorator,
                'legend' => 'Reakcja:',
            )
        );

        $this->addElement('text', 'KontrastOd', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'Od:',
            'style'    => 'width: 4em; height: 1,5em;',
            'validators' =>  array('int'),
            'ErrorMessages' => array("tylko cyfry"),
        ));

        $this->addElement('text', 'KontrastDo', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'Do:',
            'validators' =>  array('int'),
            'ErrorMessages' => array("tylko cyfry"),
            'style'    => 'width: 4em; height: 1,5em;',
        ));

        $this->addDisplayGroup(
            array('KontrastOd', 'KontrastDo'), 'Kontrast',
            array(
                'disableLoadDefaultDecorators' => true,
                'decorators' => $this->_standardGroupDecorator,
                'legend' => 'Kontrast:',
            )
        );
/*
        $options = array(
            '1024×768'      =>'---',
            '320×240'  =>'320×240',
            '640×480'  =>'640×480',
            '854×480'  =>'854×480',
            '800×600'  =>'800×600',
            '1024×768' =>'1024×768',
            '1280×720' =>'1280×720',
            '1366×768' =>'1366×768',
            '1280×800' =>'1280×800',
            '1440×900' =>'1440×900',
            '1280×1024'=>'1280×1024',
            '1600×1024'=>'1600×1024',
            '1400×1050'=>'1400×1050',
            '1024×600' =>'1024×600',
            '1680×1050'=>'1680×1050',
            '1600×1200'=>'1600×1200',
            '1920×1080'=>'1920×1080',
            '1920×1200'=>'1920×1200',
            '2048×1152'=>'2048×1152',
            '2048×1536'=>'2048×1536',
            '2560×1600'=>'2560×1600',
            '2560×2048'=>'2560×2048'
        );

        $this->addElement('select', 'RozdzielczoscOd', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'Od:',
            'MultiOptions' => $options,
            'style'    => 'width: 12em; height: 1,5em;',
        ));

        $this->addElement('select', 'RozdzielczoscDo', array(
            'decorators' => $this->_standardElementDecorator,
            'label' => 'Do:',
            'MultiOptions' => $options,
            'style'    => 'width: 12em; height: 1,5em;',
        ));

        $this->addDisplayGroup(
            array('RozdzielczoscOd', 'RozdzielczoscDo'), 'Rozdzielczosc',
            array(
                'disableLoadDefaultDecorators' => true,
                'decorators' => $this->_standardGroupDecorator,
                'legend' => 'Rozdzielczosc:',
            )
        );
*/
		$this->addElement('submit', 'submit', array(
            'decorators'=> $this->_buttonElementDecorator,
			'ignore'    => true,
			'label'     => 'Wyszukaj',
            'style'    => 'width: 17em; height: 1,5em;',
		));
    }
}
