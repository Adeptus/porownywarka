<?php

class SearchesController extends Zend_Controller_Action {

	public function indexAction() {
  		if (($this->_getParam('monitor_id') > 0) && ($this->_getParam('monitor2_id') > 0)) {
			$monitor   = $this->show_one_by_id($this->_getParam('monitor_id'));
			$monitor2  = $this->show_second_by_id($this->_getParam('monitor2_id'));
			$monitory  = $this->show_all();
		} else if ($this->_getParam('monitor_id') > 0) {
			$monitor   = $this->show_one_by_id($this->_getParam('monitor_id'));
			$monitory  = $this->show_all();
		} else {
			$monitory = $this->show_all();
		}
	}

	public function searchAction() {
		$form = new Application_Form_Search();
		$this->view->form = $form;
		if (($this->requestIsAPostAndHasValidParams($form)) && ($this->getRequest()->getParam('id'))) {
			$this->show_one_by_id($this->_getParam('id'));
		} else if (($this->requestIsAPostAndHasValidParams($form)) && ($this->getRequest()->getParam('nazwa'))) {
			$this->show_one_by_name($this->_getParam('nazwa'));
		}
	}


	private function show_one_by_id($monitor_id) {
        $monitor = new Application_Model_DbTable_Monitors();
		$this->view->monitor = $monitor->getMonitorById($monitor_id);
		$this->view->price_monitor = $this->find_price_monitor($monitor->getMonitorById($monitor_id));
	}

	private function show_second_by_id($monitor_id) {
		$monitor2 = new Application_Model_DbTable_Monitors();
		$this->view->monitor2 = $monitor2->getMonitorById($monitor_id);
		$this->view->price_monitor2 = $this->find_price_monitor($monitor2->getMonitorById($monitor_id));
    }

	private function show_all() {
		$monitory = new Application_Model_DbTable_Monitors();
		$this->view->monitory = $monitory->fetchAll();
	}

	private function show_one_by_name($name) {
		$monitor = new Application_Model_DbTable_Monitors();
		$this->view->monitor = $monitor->getMonitorByName($name);
		$this->view->price_monitor = $this->find_price_monitor($monitor->getMonitorByName($name));
	}

	private function find_price_monitor($monitor) {
		$price = new Application_Model_ParserPrice();
		$pricemonitora = $price->getPrice($monitor[marka], $monitor[nazwa]);
		return $pricemonitora;
	}
    
    private function requestIsAPostAndHasValidParams($form) {
        if (($this->getRequest()->isPost()) && ($form->isValid($this->getRequest()->getPost()))) {
           return true;
        }
    }
}
