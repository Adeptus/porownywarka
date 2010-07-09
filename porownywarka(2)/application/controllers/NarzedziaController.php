<?php

class NarzedziaController extends Zend_Controller_Action {

	public function indexAction() {

	}

	public function addAction() {
		$form    = new Application_Form_MonitorAdd();
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) {
  			$formData = $this->getRequest()->getPost();
  			if ($form->isValid($formData)) {
    	    	$marka = $form->getValue('marka');
    	    	$nazwa = $form->getValue('nazwa');
    	    	$cale = $form->getValue('Cale');
    	    	$jasnosc = $form->getValue('Jasnosc');
    	    	$reakcja = $form->getValue('Reakcja');
   	 		    $monitor = new Application_Model_DbTable_Monitory();
   			    $monitor->addMonitor($marka, $nazwa, $cale, $jasnosc, $reakcja);
   			    $this->_redirect('/');
   			} else {
     		   $form->populate($formData);
   		}
		}
	}

	public function add2Action() {
		$form    = new Application_Form_MonitorAdd2();
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) {
  			$formData = $this->getRequest()->getPost();
  			if ($form->isValid($formData)) {
				$url = $form->getValue('url');
				$wyszukana = new Application_Model_ParserSamsung();
				$tabela = $wyszukana->findMonitor($url);
				$monitor = new Application_Model_DbTable_Monitory();
   			    $monitor->addMonitor('Samsung', $tabela['nazwa'], $tabela['Rozmiar'], $tabela['Jasność (cd/m2)'], $tabela['Czas reakcji (ms)']);
   			    $this->_redirect('/');					
			}		
		}
			
	}

	public function editAction() {
		$form    = new Application_Form_MonitorEdit();
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) {
  			$formData = $this->getRequest()->getPost();
  			if ($form->isValid($formData)) {
				$id = $form->getValue('id');
    	    	$marka = $form->getValue('marka');
    	    	$nazwa = $form->getValue('nazwa');
    	    	$cale = $form->getValue('Cale');
    	    	$jasnosc = $form->getValue('Jasnosc');
    	    	$reakcja = $form->getValue('Reakcja');
    		    $monitor = new Application_Model_DbTable_Monitory();
   			    $monitor->updateMonitor($id, $marka, $nazwa, $cale, $jasnosc, $reakcja);
   			    $this->_redirect('/');
   			} else {
    	 	   $form->populate($formData);
			} 
		} else {
	    	$id = $this->_getParam('id', 0);
  	  		if ($id > 0) {
        		$monitory = new Application_Model_DbTable_Monitory();
  	       		$form->populate($monitory->getMonitor($id));
			}
  		}
	}


	public function deleteAction() {
		$form    = new Application_Form_MonitorDelete();
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) {
  			$formData = $this->getRequest()->getPost();
  			if ($form->isValid($formData)) {
				$id = $form->getValue('id');
 			    $monitor = new Application_Model_DbTable_Monitory();
   			    $monitor->deleteMonitor($id);
   			    $this->_redirect('/');
   			} else {
    	 	   $form->populate($formData);
			}   
		} else {
	    	$id = $this->_getParam('id', 0);
  	  		if ($id > 0) {
        		$monitory = new Application_Model_DbTable_Monitory();
  	       		$form->populate($monitory->getMonitor($id));
			}
  		}
	}
}
