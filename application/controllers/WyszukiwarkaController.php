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
}
