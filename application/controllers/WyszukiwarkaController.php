<?php

class WyszukiwarkaController extends Zend_Controller_Action {

	public function indexAction() {

	}

	public function wyszukajAction() {
		$monitory = new Application_Model_DbTable_Monitory();
		$this->view->monitory = $monitory->fetchAll();

	}

	public function wyszukaj2Action() {

	}
	public function znajdzAction() {
		$form = new Application_Form_Znajdz();
		$this->view->form = $form;
			if ($this->getRequest()->isPost()) {
  				$formData = $this->getRequest()->getPost();
  				if ($form->isValid($formData)) {
    	 		   	$id = $form->getValue('id');
   				    $this->_redirect('/wyszukiwarka/wynik/id/'.$id);	
//	 	 		   	$nazwa = $form->getValue('nazwa');
//   			    $monitor = new Application_Model_DbTable_Monitory();
				}		
			}
	}

	public function wynikAction() {
		$id = $this->_getParam('id', 0);		
		if ($id > 0) {
			$monitory = new Application_Model_DbTable_Monitory();
			$this->view->monitory = $monitory->getMonitor($id);
				
		}
	}

}