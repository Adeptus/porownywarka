<?php

class SearchesController extends Zend_Controller_Action {

	public function indexAction() {
	   	$id  = $this->_getParam('id', 0);
		$id2 = $this->_getParam('id2', 0);
  		if (($id > 0) && ($id2 > 0)) {
			$monitor   = $this->show_one($id);
			$monitor2  = $this->show_second($id2);
			$monitory  = $this->show_all();
		} else if ($id > 0) {
			$monitor   = $this->show_one($id);
			$monitory  = $this->show_all();
		} else {
			$monitory = $this->show_all();
		}
	}

	public function searchAction() {
		$form = new Application_Form_Search();
		$this->view->form = $form;
		if (($this->getRequest()->isPost()) && ($form->isValid($this->getRequest()->getPost())) && ($this->getRequest()->getParam('id'))) {
			$id = $form->getValue('id');
			$this->show_one($id);
		} else if (($this->getRequest()->isPost()) && ($form->isValid($this->getRequest()->getPost())) && ($this->getRequest()->getParam('nazwa'))) {
			$nazwa = $form->getValue('nazwa');
			$this->show_one_by_name($nazwa);
		}
	}


	private function show_one($id) {
			$monitor = new Application_Model_DbTable_Monitory();
			$this->view->monitor = $monitor->getMonitor($id);
	}

	private function show_second($id2) {
			$monitor2 = new Application_Model_DbTable_Monitory();
			$this->view->monitor2 = $monitor2->getMonitor($id2);
	}

	private function show_all() {
		$monitory = new Application_Model_DbTable_Monitory();
		$this->view->monitory = $monitory->fetchAll();
	}

	private function show_one_by_name($nazwa) {
			$monitor = new Application_Model_DbTable_Monitory();
			$this->view->monitor = $monitor->get2Monitor($nazwa);
	}

}
