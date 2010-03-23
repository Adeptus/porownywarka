<?php

class SearchesController extends Zend_Controller_Action {

	public function indexAction() {
	   	$id = $this->_getParam('id', 0);
  		if ($id > 0) {
			$monitor  = $this->show_one($id);
			$monitory = $this->show_all();
		} else {
			$monitory = $this->show_all();
		}
	}

	public function searchAction() {
		$form = new Application_Form_Search();
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($form->isValid($formData)) {
				if ($this->getRequest()->getParam('id')) {
					$id = $form->getValue('id');					
					$this->show_one($id);
				}
			}
		}
	}


	private function show_one($id) {
			$monitor = new Application_Model_DbTable_Monitory();
			$this->view->monitor = $monitor->getMonitor($id);
	}

	private function show_all() {
		$monitory = new Application_Model_DbTable_Monitory();
		$this->view->monitory = $monitory->fetchAll();
	}

}
