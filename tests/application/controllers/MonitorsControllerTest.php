<?php

class MonitorsControllerTest extends ControllerTestCase
{
    
    public function testAddAction() {
      $request = $this->getRequest();

      $request->setMethod('POST');
      $request->setPost(array(
        'marka' => 'bar',
        'nazwa' => 'lololo',
        'Cale' => '22',
        'Rozdzielczosc' => '22',
        'Kontrast' => '222',
        'Reakcja' => '22',
        'Jasnosc' => '22',
    ));

        $Form = $this->getMock('Application_Form_MonitorAdd', array('isValid'));
        $Form->expects($this->any())->method('isValid')
                       ->will($this->returnValue(false));
        Application_Form_Factory::setForm($Form);

      $this->dispatch('monitors/add');
      $this->assertNotRedirect();
    }
}

