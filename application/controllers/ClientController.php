<?php

require_once 'Excel/reader.php';

class ClientController extends Zend_Controller_Action {

    protected $modelCompanies;
    protected $modelCategories;
    protected $modelMonitory;
    protected $modelMemory;

    public function preDispatch() {
        $this->modelCompanies  = new Application_Model_DbTable_Companies();
        $this->modelCategories = new Application_Model_DbTable_Categories();
        $this->modelMonitory   = new Application_Model_DbTable_Monitors();
        $this->modelMemory     = new Application_Model_DbTable_Memory();
    }

    public function indexAction() {
        $this->view->categories = $this->modelCategories->fetchAll();
        if ($this->getRequest()->isPost()) {
            $this->getSearcheResults($this->_getParam('searchValue'));
        }
    }

    public function searchAction() {
        $this->view->categories = $this->modelCategories->fetchAll();
        $category = $this->_getParam('category');
        $fieldsNamesArray = $this->getFieldsNamesForCategory($category);
        $tableWithAllValueEveryFields = $this->getAllValueEveryFields($category, $fieldsNamesArray);
        $this->view->category = $category;
        $this->view->fieldsNamesArray = $fieldsNamesArray;
        $this->view->tableWithAllValueEveryFields = $tableWithAllValueEveryFields;
        if ($this->getRequest()->isPost()) {
            if ($this->_getParam('compare')) {
                $allItemsNamesFromCategory = $this->getAllItemsNamesFromTable($category); 
                foreach ($allItemsNamesFromCategory as $itemName) {
                    $itemName = $itemName['nazwa'];
                    if($this->_getParam("$itemName")) {
                        $itemsToCompare[] = $this->_getParam("$itemName");
                    }
                }
                $itemsCommaSeparated = implode(",", $itemsToCompare);
                $this->_redirect("/client/compare/category/$category/items/$itemsCommaSeparated");
            }  
            foreach ($fieldsNamesArray as $fieldName) {
                for ($i=0 ; $i<=(count($tableWithAllValueEveryFields[$fieldName])); $i++) {
                    if ($this->_getParam("$fieldName$i") != null) {
                        $searchParameters[$fieldName][] = $this->_getParam("$fieldName$i");
                    }
                } 
            }  
            $this->view->items = $this->getAllRowBySearchParameters($searchParameters, $fieldsNamesArray, $category);
        }   else $this->view->items = $this->getAllRowInTable($category);         
    }

    public function compareAction() {
        $category = $this->_getParam('category');
        $itemsToCompare = $this->_getParam('items');
        $itemsToCompare = $this->preperListToDatabasePrefer($itemsToCompare);
        $itemFromDatabase = $this->getItemsFromList($itemsToCompare, $category);
        
        print_r ($itemFromDatabase);

        print_r ($itemsToCompare);
    }

    private function getAllValueEveryFields($tableName, $fieldsNamesArray) {
        foreach ($fieldsNamesArray as $fieldName) {
            $tableWithAllValueEveryFields[$fieldName] = $this->getAllParametersFromTableName($fieldName, $tableName);
        }
        return $tableWithAllValueEveryFields;
    }

    private function getAllParametersFromTableName($parameter, $tableName) {
        $db = Zend_Registry::get('default');
        $selectToUnion = $db->select()->from(array("$tableName"), "$parameter");
        $select = $db->select()->union(array($selectToUnion, $selectToUnion));    
        return $db->fetchAll($select);
    }

    private function getAllRowInTable($tableName) {
        $db = Zend_Registry::get('default');
        $select = $db->select()->from($tableName);
        return $this->doDatabaseQuestion($select);       
    }

    private function getAllRowBySearchParameters($searchParameters, $fieldsNamesArray, $category) {
        $db = Zend_Registry::get('default');
        $select = $db->select()->from($category);
        foreach ($fieldsNamesArray as $fieldName) {
            if ($searchParameters[$fieldName]) {
                $this->addToSearchStatisticsInCategory($searchParameters[$fieldName], $fieldName, $category);
                $arrayCommaSeparated = "'".implode("','", $searchParameters[$fieldName])."'";
                $select->where("$fieldName IN ($arrayCommaSeparated)");
            }
        } return $this->doDatabaseQuestion($select);
    }

    private function doDatabaseQuestion($select){
        $db = Zend_Registry::get('default');
        $itemsRow = $db->fetchAll($select); 
		if (!$itemsRow) {
			$this->view->errorMessage = "Nic nie znalezion w bazie";
		} return $itemsRow;
    }

    private function addToSearchStatisticsInCategory($searchValues, $parameter, $tableName) {
        $db = Zend_Registry::get('default');
        foreach ($searchValues as $value) {
            $numberSearches = $this->getNumberSearches($parameter, $value, $tableName);
            if ($numberSearches != null) {
                $NewNumberSearches = $numberSearches['numberSearches'] + 1;
                $db->query("UPDATE statistics$tableName SET numberSearches = $NewNumberSearches WHERE parameter = '$parameter' AND value = '$value'");
            } else $db->query("INSERT INTO statistics$tableName VALUES ('$parameter', '$value', 1)");
        }
    }

    private function getNumberSearches($parameter, $value, $tableName) {
        $db = Zend_Registry::get('default');
        $select = $db->select()
                     ->from(array("statistics$tableName"), 'numberSearches')
                     ->where('parameter = ?', $parameter)
                     ->where('value = ?', $value);
        $row = $db->fetchRow($select);
        if(!row) {
            return null;
        } else return $row;
    }

    private function getAllItemsNamesFromTable($category) {
        $db = Zend_Registry::get('default');        
        $select = $db->select()
                     ->from(array("$category"), 'nazwa');
        return $this->doDatabaseQuestion($select);        
    }

    private function preperListToDatabasePrefer($itemList) {
        $itemList = str_replace(",", "','", $itemList);
        $itemList = str_replace("$itemList", "'$itemList'", $itemList);
        return $itemList;
    }

    private function getItemsFromList($itemList, $tableName) {
        $db = Zend_Registry::get('default');        
        $select = $db->select()
                     ->from($tableName)
                     ->where("nazwa IN ($itemList)");      
        return $this->doDatabaseQuestion($select);
    }

    public function getFieldsNamesForCategory($category) {
        if ($category == "monitory") {
            $this->view->fieldsDescriptions = $this->modelMonitory->getFieldsDescriptions();       
            return $this->modelMonitory->getFieldsNames();
        } else if ($category = "memory") {
            $this->view->fieldsDescriptions = $this->modelMemory->getFieldsDescriptions();
            return $this->modelMemory->getFieldsNames();
        }
    }

}
