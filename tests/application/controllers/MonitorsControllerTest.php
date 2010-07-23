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
        'Jasnosc' => 'b22',
    ));

      $this->dispatch('/monitors/add/');
      $this->assertRedirectTo('/searches/index/');
    }

}

