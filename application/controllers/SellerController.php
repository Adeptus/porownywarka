<?php

class SellerController extends Zend_Controller_Action
{

    protected $model;
    protected $modelDelivery;
    protected $modelCategories;
    protected $modelMonitory;
       
    public function preDispatch() {
        $this->model = new Application_Model_DbTable_Companies();
        $this->modelDelivery = new Application_Model_DbTable_Delivery();
        $this->modelCategories = new Application_Model_DbTable_Categories();
        $this->modelMonitory = new Application_Model_DbTable_Monitors();
    }

    public function indexAction()
    {
        if ($this->_getParam('id') > 0) {
            $this->view->user = $this->_getParam('id');
        } else {
    		$this->view->companies = $this->model->fetchAll();
        }
    }

    public function shopinfoAction()
    {
        $parser = new Application_Model_ParserWspolrzedne();
		$form    = new Application_Form_Seller_ShopInfo();
    	$this->view->form = $form;

        if ($this->_getParam('id') > 0) {
    		$company = $this->model->getCompanyById($this->_getParam('id'));
            $form->populate($company);
            $this->view->dane = array($company['wspolrzedne'], $company['nazwa'], $company['adres'], $company['kod'], $company['miasto'], $company['dostawa'], $company['id']);

            $deliveryOptions = $this->modelDelivery->getDeliveriesByCompanyId($this->_getParam('id')); 
            if ($deliveryOptions['dostawa'] != null) {           	
                $this->view->deliveryOptions  = $deliveryOptions;
                $this->view->defaultdelivery = $company['dostawa'];
            }

            $formDelivery = new Application_Form_Seller_Delivery();
        	$this->view->formDelivery = $formDelivery; 

            if (($this->requestIsAPostAndHasValidParams($formDelivery)) or ($this->requestIsAPostAndHasValidParams($form))) {
                if ($this->requestIsAPostAndHasValidParams($formDelivery)) { 
                    $deliverynumber = $formDelivery->getValue('delivery');
                    $newDeliveryText = $formDelivery->getValue('addDelivery');
                    if (($deliverynumber != null) or ($newDeliveryText != null)) {
                        if ($formDelivery->getValue('koszt') == 0) {
                            $deliveryPrice = null;
                        } else $deliveryPrice = $formDelivery->getValue('koszt');

                        if($deliverynumber != null) {
                            $this->model->updateCompanyDelivery($this->_getParam('id'), $deliverynumber);
                        }

                        if  ($newDeliveryText != null) {
                            $deliverynumber = 1;
                            while ($this->modelDelivery->getDeliveryByCompanyIdAndNumber($this->_getParam('id'), $deliverynumber) != null) {
                                $deliverynumber++;
                           }               
                           $this->modelDelivery->addDelivery(null, $this->_getParam('id'), $deliverynumber, $newDeliveryText, $deliveryPrice);
                        } 
        
                        $this->_redirect('/seller/shopinfo/id/'.$this->_getParam("id"));
                    }
                } 
                if ($this->requestIsAPostAndHasValidParams($form)) {
                    $wspolrzedne = $parser->findWspolrzedne($form->getValue('adres'), $form->getValue('miasto'));
                    $this->model->updateCompany($this->_getParam('id'), $form->getValue('nazwa'), $form->getValue('adres'), $form->getValue('kod'), $form->getValue('miasto'), $form->getValue('mail'), $form->getValue('tel'), $wspolrzedne);
                    $this->_redirect('/seller/shopinfo/id/'.$this->_getParam("id"));
                } else $this->_redirect('/seller/shopinfo/id/'.$this->_getParam("id"));
            } 
            
        } else {
      		if ($this->requestIsAPostAndHasValidParams($form)) {
                $wspolrzedne = $parser->findWspolrzedne($form->getValue('adres'), $form->getValue('miasto'));
                $this->model->addCompany(null, $form->getValue('nazwa'), $form->getValue('adres'), $form->getValue('kod'), $form->getValue('miasto'), $form->getValue('mail'), $form->getValue('tel'), null, $wspolrzedne);
                $company = $this->model->getCompanyByName($form->getValue('nazwa'));
                $this->_redirect('/seller/shopinfo/id/'.$company["id"]);
            }            
        }

    }

    public function addofferAction()
    {
        if($this->getRequest()->isPost()) {
            if ($this->_getParam('category')) {
                $category = $this->_getParam('category');
                if ($category != null) {
                    $db = Zend_Registry::get('default');

                    $selectA = $db->select()
                                      ->from(array("$category"), 'marka');
                    $select = $db->select()->union(array($selectA, $selectA));    
                    $rows = $db->fetchAll($select);
                    
                    $this->view->producers = $rows;
                }
            } else if ($this->_getParam('name')) {
                if ($this->modelMonitory->getMonitorByName($this->_getParam('name')) != null) {
                    echo 'HUJJJJJJJJJJJJJJJJJJJJJJ';
                }   
            }
        } else $this->view->categories = $this->modelCategories->fetchAll();
    }

    public function offersAction()
    {
        // action body
    }

    public function deletedeliveryAction()
    {
        $this->modelDelivery->deleteDelivery($this->_getParam('delivery_id'));
        $this->_redirect('/seller/shopinfo/id/'.$this->_getParam("id"));           
    }

    private function requestIsAPostAndHasValidParams($form) {
        if (($this->getRequest()->isPost()) && ($form->isValid($this->getRequest()->getPost()))) {
           return true;
        }
    }

}

