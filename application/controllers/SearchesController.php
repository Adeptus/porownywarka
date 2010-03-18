<?php

class SearchesController extends Zend_Controller_Action {

	public function indexAction() {

	}

	public function searchAction() {
	   	$id = $this->_getParam('id', 0);
  		if ($id > 0) {
			$this->showAction($id);
		} else {
			$monitory = new Application_Model_DbTable_Monitory();
			$this->view->monitory = $monitory->fetchAll();
		}
	}

	public function findAction() {
		$form = new Application_Form_Znajdz();
		$this->view->form = $form;
			if ($this->getRequest()->isPost()) {
  				$formData = $this->getRequest()->getPost();
  				if ($form->isValid($formData)) {
    	 		   	$id = $form->getValue('id');
   				    $this->_redirect('/searches/search/id/'.$id);	
//	 	 		   	$nazwa = $form->getValue('nazwa');
//   			    $monitor = new Application_Model_DbTable_Monitory();
				}		
			}
	}

	protected function showAction($id) {
			$monitory = new Application_Model_DbTable_Monitory();
			$this->view->monitory = $monitory->getMonitor($id);
	}

}
