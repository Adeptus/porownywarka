<?php

class Application_Form_MonitorAdd extends Zend_Form {

	public function init() {

		$this->setMethod('post');
        $this->setAttrib('id', 'subscribe-form');		
		$this->addElement('text', 'marka', array(
			'label'      =>	'Podaj nazwe producenta:',
			'required'   =>   true,
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('text', 'nazwa', array(
			'label'      =>	'Podaj nazwe produktu:',
			'required'   =>   true,
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('text', 'Cale', array(
//			'value'      =>  $cale,
			'label'      =>	'Podaj wielkosc matryce w calach:',
			'required'   =>   true,
            'validators' =>  array(array('regex', true, array('/^[0-9]{2}(\,|\.)?[0-9]?$/'))),
            'ErrorMessages' => array("Wartos moze skladac sie z dwuch cyfr(oraz ewentualnej liczby po przecinku)"),
            'style'    => 'width: 4em; height: 1,5em;',
            'maxlength'   => 4,
		));

		$this->addElement('text', 'Jasnosc', array(
//			'value'      =>  $jasnosc,
			'label'      =>	'Podaj Jasnosc(cd/m2):',
			'required'   =>   true,
            'validators' =>  array('int'),
            'ErrorMessages' => array("Wartos moze skladac sie tylko z cyfr."),
//            'style'    => 'width: 4em; height: 1,5em;',
		));

		$this->addElement('text', 'Reakcja', array(
//			'value'      =>  $reakcja,
			'label'      =>	'Podaj czas reakcji matrycy(sek):',
			'required'   =>   true,
            'validators' =>  array('int'),
            'ErrorMessages' => array("Wartos moze skladac sie tylko z cyfr."),
		));

		$this->addElement('text', 'Kontrast', array(
//			'value'      =>  $kontrast,
			'label'      =>	'Podaj kontrast(x:1):',
			'required'   =>   true,
            'validators' =>  array('alnum', array('regex', true, array('/^[0-9]{2,7}$/'))),
            'ErrorMessages' => array("Wartos moze skladac sie tylko z cyfr(min.2 max.7)"),
		));

        $options = array(
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

		$this->addElement('select', 'Rozdzielczosc', array(
//			'value'      =>  $rozdzielczosc,
			'label'      =>	'Podaj rozdzielczosc:',
			'required'   =>   true,
            'MultiOptions' => $options,
		));

		$this->addElement('text', 'Katy', array(
//			'value'      =>  $katy,
			'label'      =>	'Podaj katy widocznosc (poziomo stopni/pionowo stopni):',
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('text', 'Kolor', array(
//			'value'      =>  $kolor,
			'label'      =>	'Podaj kolor obrazu(mln):',
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('text', 'Pobor', array(
//			'value'      =>  $pobor,
			'label'      =>	'Podaj pobor prądu(kw):',
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('text', 'Czuwanie', array(
//			'value'      =>  $czuwanie,
			'label'      =>	'Podaj pobor prądu podczas czuwania(kw):',
			'filters'    =>   array('StringTrim'),
		));
	
		$this->addElement('text', 'Waga', array(
//			'value'      =>  $waga,
			'label'      =>	'Podaj wage monitora(kg):',
			'filters'    =>   array('StringTrim'),
		));

		$this->addElement('captcha', 'captcha', array(
			'label'      => 'Wprowadz 5 ponizszych liter:',
			'required'   => true,
			'captcha'    => array(
				'captcha'  =>  'Figlet',
				'wordLen'  =>  5,
				'timeout'  =>  300
			)
		));

		$this->addElement('submit', 'submit', array(
			'ignore'    => true,
			'label'     => 'Dodaj Przedmiot',
		));

	}
}

