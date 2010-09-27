<?php

class SearchesController extends Zend_Controller_Action {

        protected $model;
        
        public function preDispatch() {
            $this->model = new Application_Model_DbTable_Monitors();
        }


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
    		$this->view->item = $this->model->getMonitorById($this->_getParam('id'));
		} else if (($this->requestIsAPostAndHasValidParams($form)) && ($this->getRequest()->getParam('nazwa'))) {
    		$this->view->item = $this->model->getMonitorById($this->_getParam('nazwa'));
		}
	}

	public function searchbyparametersAction() {
		$form = new Application_Form_SearchByParameters();
		$this->view->form = $form;
        $formData = $this->getRequest()->getPost();
        if ($this->requestIsAPostAndHasValidParams($form)) {
            $TableCale          = $this->checkFormValueAndGetIdsByParameters('Cale',    $form->getValue('CaleOd'),    $form->getValue('CaleDo'));
            $TableJasnosc       = $this->checkFormValueAndGetIdsByParameters('Jasnosc', $form->getValue('JasnoscOd'), $form->getValue('JasnoscDo'));
            $TableReakcja       = $this->checkFormValueAndGetIdsByParameters('Reakcja', $form->getValue('ReakcjaOd'), $form->getValue('ReakcjaDo'));
            $TableKontrast      = $this->checkFormValueAndGetIdsByParameters('Kontrast', $form->getValue('KontrastOd'), $form->getValue('KontrastDo'));
            $TableRozdzielczosc = $this->checkFormValueAndGetIdsByParameters('Rozdzielczosc', $form->getValue('RozdzielczoscOd'), $form->getValue('RozdzielczoscDo'));
            if (($TableCale != null) and ($TableJasnosc != null) and ($TableKontrast != null) and ($TableReakcja != null) and ($TableRozdzielczosc != null)) {       
        		$MonitorsIds = array_intersect($TableCale, $TableJasnosc, $TableKontrast, $TableReakcja, $TableRozdzielczosc);
                foreach ($MonitorsIds as $MonitorId) {
                    $monitory[] = $this->model->getMonitorById($MonitorId);
                }
                $this->view->monitory = $monitory;         
            } else {
                
            }
        } else {
            $form->populate($formData);
        }
        if ($this->_getParam('monitor_id') > 0) {
			$monitor   = $this->show_one_by_id($this->_getParam('monitor_id'));
            $form->populate($formData);
        }
	}


	private function show_one_by_id($monitor_id) {
   		$this->view->monitor = $this->model->getMonitorById($monitor_id);
    	$this->view->price_monitor = $this->find_price_monitor($this->model->getMonitorById($monitor_id));
    }

	private function show_second_by_id($monitor_id) {
		$this->view->monitor2 = $this->model->getMonitorById($monitor_id);
		$this->view->price_monitor2 = $this->find_price_monitor($this->model->getMonitorById($monitor_id));
    }

	private function show_all($order = null) {
		$this->view->monitory = $this->model->fetchAll($order);
	}

	private function show_one_by_name($name) {
		$this->view->monitor = $this->model->getMonitorByName($name);
		$this->view->price_monitor = $this->find_price_monitor($this->model->getMonitorByName($name));
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

    private function checkFormValueAndGetIdsByParameters($parameter, $ValueMin, $ValueMax) {
        if (($ValueMin == null) && ($ValueMax == null)) {
            return $this->model->getIdsByParameters($parameter, 1);
        } else {
            return $this->model->getIdsByParameters($parameter, $ValueMin, $ValueMax);
        }
    }
}
