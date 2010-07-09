<?php

class SearchesControllerTest extends ControllerTestCase
{
    public function testIndexAction()
    {
        $this->dispatch('/index');
        $this->assertController('index');
        $this->assertAction('index');
	}


}
