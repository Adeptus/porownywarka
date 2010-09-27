<?php

require_once 'Excel/reader.php';

class SellerController extends Zend_Controller_Action
{

    protected $model;
    protected $modelDelivery;
    protected $modelCategories;
    protected $modelOffers;

       
    public function preDispatch() {
        $this->model           = new Application_Model_DbTable_Companies();
        $this->modelDelivery   = new Application_Model_DbTable_Delivery();
        $this->modelCategories = new Application_Model_DbTable_Categories();
        $this->modelOffers     = new Application_Model_DbTable_Offers();
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

    public function addofferAction() {
        $this->view->user = $this->_getParam('id');
        if($this->getRequest()->isPost()) {
            $category = $this->_getParam('category');
            $itemPrice    = $this->_getParam('itemPrice');
            if ($category) {
                $itemName     = $this->_getParam('itemName');
                $producerName = $this->_getParam('producer');
                if ($itemName) {
                    $getItemByNameAndProducer = $this->getItemByNameAndProducerInTable($itemName, $producerName, $category);
                    if ($getItemByNameAndProducer != null) {
                        $this->getAllItemCategoriesToView(); 
                        $this->view->actualCategory  = $category;
                        $this->view->producers       = $this->getAllProducersFromTableName($category);
                        $this->view->item            = $getItemByNameAndProducer;
                        $this->view->deliveryOptions = $this->modelDelivery->getDeliveriesByCompanyId($this->_getParam('id'));
                        $company                     = $this->model->getCompanyById($this->_getParam('id'));
                        $this->view->defaultDelivery = $this->modelDelivery->getDeliveryByCompanyIdAndNumber($company['id'], $company['dostawa']);
                    } else {
                        $this->getAllItemCategoriesToView(); 
                        $this->view->actualCategory = $category;
                        $this->view->producers      = $this->getAllProducersFromTableName($category);
                        $this->view->item           = array('nazwa' => $itemName , 'marka' => $producerName);
                        $this->view->errorMessage   = "Przedmiot $itemName producenta $producerName nie istnieje";
                    }
                } else {
                    $this->getAllItemCategoriesToView();
                    $this->view->actualCategory = $category;
                    $this->view->producers      = $this->getAllProducersFromTableName($category);
                }
            } else if ($itemPrice) {
                $addOffer = $this->modelOffers->addoffer($id =null,
                                                         $itemPrice, 
                                                         $this->_getParam('promotion'),
                                                         $this->_getParam('delivery'),
                                                         $this->_getParam('description'),
                                                         $this->_getParam('link'),
                                                         $this->_getParam('state'),
                                                         $this->_getParam('pricewholesale'),
                                                         $this->_getParam('installment'),
                                                         $this->_getParam('id'),
                                                         $this->_getParam('itemParameterActualCategory'),
                                                         $this->_getParam('itemParameterProducer'),
                                                         $this->_getParam('itemParameterName'));

                $this->updateNumberOffersByAddInCategory($this->_getParam('itemParameterActualCategory'));
                $this->_redirect('/seller/addoffer/id/'.$this->_getParam("id"));   
            } else {
                $this->getAllItemCategoriesToView(); 
                $this->view->actualCategory  = $this->_getParam('itemParameterActualCategory');
                $this->view->producers       = $this->getAllProducersFromTableName($this->_getParam('itemParameterActualCategory'));
                $this->view->item            = $this->getItemByNameAndProducerInTable($this->_getParam('itemParameterName'),
                                                                                      $this->_getParam('itemParameterProducer'),
                                                                                      $this->_getParam('itemParameterActualCategory'));
                $this->view->deliveryOptions = $this->modelDelivery->getDeliveriesByCompanyId($this->_getParam('id'));
                $company                     = $this->model->getCompanyById($this->_getParam('id'));
                $this->view->defaultDelivery = $this->modelDelivery->getDeliveryByCompanyIdAndNumber($company['id'], $company['dostawa']);
                $this->view->errorMessage   = "Offerta nie została dodana. Musisz wpisać cene";  
            }
        } else $this->getAllItemCategoriesToView();
    }

    public function offersAction() {
        $this->view->categories = $this->findAllCategoryCompanyId($this->_getParam('id'));
        if($this->getRequest()->isPost()) {
            $this->view->actualCategory = $this->_getParam('category');
            $this->view->allOffers = $this->modelOffers->getAllOffersFromCategoryCompanyId($this->_getParam('category'), $this->_getParam('id'));
        } else $this->view->allOffers = $this->modelOffers->getAllOffersCompanyById($this->_getParam('id'));
    }

    public function deletedeliveryAction() {
        $this->modelDelivery->deleteDelivery($this->_getParam('delivery_id'));
        $this->_redirect('/seller/shopinfo/id/'.$this->_getParam("id"));           
    }

    public function deleteofferAction() {
        $this->modelOffers->deleteOffer($this->_getParam('offer_id'));
        $this->updateNumberOffersByDeleteInCategory($this->_getParam('category'));
        $this->_redirect('/seller/offers/id/'.$this->_getParam("id"));           
    }

    public function uploadoffersAction() { //Funkcja nie dziala. nie ma uprawnien. na serwerze jakos sie udalo. ale na razie funkcja w rozsypce

//        if($this->getRequest()->isPost()) {
//        $adapter = new Zend_File_Transfer_Adapter_Http();
//        $adapter->setDestination('/tmp/');
//       }
        $plik_tmp = $_FILES['plik']['tmp_name']; 
        $plik_nazwa = $_FILES['plik']['name']; 
        $plik_rozmiar = $_FILES['plik']['size']; 

        if(is_uploaded_file($plik_tmp)) { 
             move_uploaded_file($plik_tmp, "/home/adeptus/upload/$plik_nazwa"); 
            echo "Plik: <strong>$plik_nazwa</strong> o rozmiarze 
            <strong>$plik_rozmiar bajtów</strong> został przesłany na serwer!"; 
        }
    }

    public function addoffersbyxlsAction() {
        $this->getAllItemCategoriesToView();
        if($this->getRequest()->isPost()) {
            $arrayWithOffersFromXls = $this->readXlsFileAndAddToArray($this->_getParam('fileName'));
            if ($arrayWithOffersFromXls != null) {
                $table = $this->addAllOffersFromArrayWithOffersAndUseUserPreferences($arrayWithOffersFromXls,
                                                                            $this->_getParam('categoryColumn'),
                                                                            $this->_getParam('producersColumn'),
                                                                            $this->_getParam('nameColumn'),
                                                                            $this->_getParam('priceColumn'));
                print_r ($table);
            } else $this->view->errorMessage   = "Taki Plik nie istnieje. upewnij się że taka wprowadziłeś poprawna nazwe";   
        }
    }

    private function readXlsFileAndAddToArray($fileName) { //na razie sciezka podpieta na sztywno
        $xls = new Spreadsheet_Excel_Reader();               
        $xls->setOutputEncoding('cp1250');
        $xls->read('/home/adeptus/www/porownywarka/library/Excel/Untitled.xls'); //problem z dlugoscia sciezki do rozwiazania
        return $xls->sheets[0]['cells'];
    }

    private function addAllOffersFromArrayWithOffersAndUseUserPreferences($arrayWithOffers, $categoryColumn, $producersColumn, $itemNameColumn, $priceColumn) {
        foreach ($arrayWithOffers as $offer) {
            if ($this->modelCategories->checkCategoryExist($offer[$categoryColumn]) != null) {
                if($this->getItemByNameAndProducerInTable($offer[$itemNameColumn], $offer[$producersColumn], $offer[$categoryColumn]) != null) {
                    if(is_numeric($offer[$priceColumn])) {                    
                        $this->modelOffers->addoffer(null, $offer[$priceColumn], null, null, null, null, 1, null, null, $this->_getParam('id'),
                                                         $offer[$categoryColumn],
                                                         $offer[$producersColumn],
                                                         $offer[$itemNameColumn]);
                        $this->updateNumberOffersByAddInCategory($offer[$categoryColumn]);
                        $tableWithInfo['correct'][] = $offer[$itemNameColumn];
                    } else $tableWithInfo['priceErrors'][] = $offer[$priceColumn];
                } else $tableWithInfo['itemExistErrors'][] = array($offer[$producersColumn], $offer[$itemNameColumn]);             
            } else $tableWithInfo['categoryErrors'][] = $offer[$categoryColumn];
        }   return $tableWithInfo;
    }


    private function requestIsAPostAndHasValidParams($form) {
        if (($this->getRequest()->isPost()) && ($form->isValid($this->getRequest()->getPost()))) {
           return true;
        }
    }

    private function getAllItemCategoriesToView() {
        $this->view->categories = $this->modelCategories->fetchAll();
    }

    private function getAllProducersFromTableName($tableName) {
        $db = Zend_Registry::get('default');
        $selectToUnion = $db->select()->from(array("$tableName"), 'marka');
        $select = $db->select()->union(array($selectToUnion, $selectToUnion));    
        return $db->fetchAll($select);
    }
    
    private function getItemByNameAndProducerInTable($itemName, $producerName, $tableName) {
        $db = Zend_Registry::get('default');
        $select = $db->select()
                     ->from($tableName)
                     ->where("nazwa = ?", $itemName)
                     ->where("marka = ?", $producerName);
        $itemRow = $db->fetchRow($select); 
		if (!$itemRow) {
			return null;
		}
		return $itemRow;      
    }

    private function updateNumberOffersByAddInCategory($category) {
        $categoryRow = $this->modelCategories->getAllRowFromCategory($category);
        $numberOffers = $categoryRow['number_offers'] + 1;       
        $this->modelCategories->updateNumberOffersInCategory($numberOffers, $categoryRow['id']);
    }

    private function updateNumberOffersByDeleteInCategory($category) {
        $categoryRow = $this->modelCategories->getAllRowFromCategory($category);
        $numberOffers = $categoryRow['number_offers'] - 1;       
        $this->modelCategories->updateNumberOffersInCategory($numberOffers, $categoryRow['id']);
    }

    private function findAllCategoryCompanyId($id) {
        $db = Zend_Registry::get('default');
        $query  = "SELECT categories.* FROM categories, offers WHERE categories.name = offers.category_name AND offers.company_id = $id";
        $query2 = "SELECT * from categories";
//        $select = $db->select($query);
//                       ->from(array('c' => 'categories', 'o' => 'offers'), array('c.id', 'c.name'))
//                       ->where("c"."name = "o"."category_name")
//                       ->where("o.company_id = ?", $id);
        $select = $db->select()->union(array($query, $query2));
        return $db->fetchAll($select);
    }

}

