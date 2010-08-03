<?php

class SearchesControllerTest extends ControllerTestCase
{
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
        $this->dispatch('/searches/searchByParameters');
        $this->assertXpath("//form//input[@name='CaleOd'][@value='22']");
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

    private function _validateForm($returnValue = true) {
        $Form = $this->getMock('Application_Form_SearchByParameters', array('isValid'));
        $Form->expects($this->any())->method('isValid')
                       ->will($this->returnValue($returnValue));
        Application_Form_Factory::setForm($Form);
    }
}
