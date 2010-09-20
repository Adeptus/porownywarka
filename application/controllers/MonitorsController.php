<?php

class MonitorsController extends Zend_Controller_Action {

	public function indexAction() {

	}
	public function addAction() {
		$form    = Application_Form_Factory::create();
		$this->view->form = $form;

		if ($this->getRequest()->isPost()) {
        $formData = $this->getRequest()->getPost();
  			if ($form->isValid($formData)) {
				$monitor = new Application_Model_DbTable_Monitors();
   			    $addMonitor = $monitor->addMonitor(null, $form->getValue('marka'), $form->getValue('nazwa'), $form->getValue('Cale'), $form->getValue('Jasnosc'), $form->getValue('Reakcja'), $form->getValue('Kontrast'), $form->getValue('Rozdzielczosc'), $form->getValue('Katy'), $form->getValue('Kolor'), $form->getValue('Pobor'), $form->getValue('Czuwanie'), $form->getValue('Waga'));
                if ($addMonitor  === true) { 
                    $monitor_id = $monitor->getMonitorByName($form->getValue('nazwa'));  			    
                    $this->_redirect('/searches/index/monitor_id/'.$monitor_id['id']);
                } else if ($addMonitor  === $error1) { 
                	$this->view->error = $addMonitor;
           		    $form->populate($formData);             
                } else {
                	$this->view->error = $addMonitor;
           		    $form->populate($formData);
                }
   			} else {
     		   $form->populate($formData);
   		    }
		}
	}

	public function addbyparsingAction() {
		$form    = new Application_Form_MonitorAddByParsing();
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) {
        $formData = $this->getRequest()->getPost();
  			if ($form->isValid($formData)) {
			    if (($this->getRequest()->getParam('producent')) === 'samsung') {
					$szukana = $form->getValue('nazwa');
					$wyszukana = new Application_Model_ParserSamsung();
					$tabela = $wyszukana->findMonitor($szukana);
					if (isset($tabela['Rozmiar'])) {					
						$monitor = new Application_Model_DbTable_Monitors();
   					    $monitor->addMonitor(null, 'Samsung', $tabela['nazwa'], $tabela['Rozmiar'], $tabela['Jasność (cd/m2)'], $tabela['Czas reakcji (ms)'],$tabela['Kontrast'], $tabela['Rozdzielczość'], $tabela['Kąty widoczności (poziomo/pionowo)'], $tabela['Kolor obrazu'], $tabela['Włączony'], $tabela['Tryb czuwania (DPMS)'], $tabela['Netto (kg)']);
                        $monitor_id = $monitor->getMonitorByName($tabela['nazwa']);  			    
                        $this->_redirect('/searches/index/monitor_id/'.$monitor_id['id']);				
					} else $this->_redirect('/monitors/add/');
				} else $this->_redirect('/monitors/add/');
			}
		}
			
	}

	public function editAction() {
		$form    = new Application_Form_MonitorEdit();
		$this->view->form = $form;
        $monitor = new Application_Model_DbTable_Monitors();
		if ($this->getRequest()->isPost()) {
        $formData = $this->getRequest()->getPost();
  			if ($form->isValid($formData)) {
   			    $monitor->updateMonitor($form->getValue('id'), $form->getValue('marka'), $form->getValue('nazwa'), $form->getValue('Cale'), $form->getValue('Jasnosc'), $form->getValue('Reakcja'), $form->getValue('Kontrast'), $form->getValue('Rozdzielczosc'), $form->getValue('Katy'), $form->getValue('Kolor'), $form->getValue('Pobor'), $form->getValue('Czuwanie'), $form->getValue('Waga'));
   			    $this->_redirect('/searches/index/monitor_id/'.$form->getValue('id'));
   			} else {
    	 	   $form->populate($formData);
			} 
		} else {
  	  		if ($this->_getParam('id') > 0) {
                $monitorTable = $monitor->getMonitorById($this->_getParam('id'));
  	       		$form->populate($monitorTable->toArray());
			}
  		}
	}


	public function deleteAction() {
		$form    = new Application_Form_MonitorDelete();
		$this->view->form = $form;
        $monitor = new Application_Model_DbTable_Monitors();		
        if ($this->getRequest()->isPost()) {
        $formData = $this->getRequest()->getPost();
  			if ($form->isValid($formData)) {
   			    $monitor->deleteMonitor($form->getValue('id'));
   			    $this->_redirect('/searches/index/');
   			} else {
    	 	   $form->populate($formData);
			}   
		} else {
  	  		if ($this->_getParam('id') > 0) {
                $monitorTable = $monitor->getMonitorById($this->_getParam('id'));
  	       		$form->populate($monitorTable->toArray());
			}
  		}
	}
}
