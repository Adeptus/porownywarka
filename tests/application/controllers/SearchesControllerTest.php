<?php

class SearchesControllerTest extends ControllerTestCase
{

    public function setUp() {
        parent::setUp();
		$this->_db = Zend_Registry::get('test');
    }

    public function testIndexAction()
    {
        $this->dispatch('/index');
        $this->assertController('index');
        $this->assertAction('index');
	}

    public function testSearchByParametersAction() {
        $this->dispatch('/searches/searchByParameters');
        $this->assertXpath("//form//input[@name='CaleOd']");
    }

    public function testSearchByParametersActionWithValidForm() {
        $this->_validateForm();
        $request = $this->getRequest()->setMethod('POST');     
        $request->setPost(array(
          'CaleOd'    => '22',
          'JasnoscDo' => '500',  
        ));
        
        $this->model = new Application_Model_DbTable_Monitors();
        $this->model->setupDatabaseTest();

        $this->dispatch('/searches/searchByParameters');
        
        $this->assertXpath("//form//input[@name='CaleOd'][@value='22']");
        $this->assertQuery('a[href="/monitors/edit/id/79"]');
        $this->assertNotQuery('a[href="/monitors/edit/id/14"]');
    }

    public function testSearchByParametersActionWithInValidForm() {
        $this->_validateForm(false);
        $request = $this->getRequest()->setMethod('POST');     
        $request->setPost(array(
          'CaleOd' => '22s',
        ));
        $this->dispatch('/searches/searchByParameters');
        $this->assertQuery('ul[class="errors"]');
    }

    public function testSearchesPageWithMonitorIdInPath() {
        $this->dispatch('/searches/searchByParameters/monitor_id/79');
        $this->assertXpath("//table//tr//div[class='span-6']");
    }

    private function _validateForm($returnValue = true) {
        $Form = $this->getMock('Application_Form_SearchByParameters', array('isValid'));
        $Form->expects($this->any())->method('isValid')
                       ->will($this->returnValue($returnValue));
        Application_Form_Factory::setForm($Form);
    }
}
