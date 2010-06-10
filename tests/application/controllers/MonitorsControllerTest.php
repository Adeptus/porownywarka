<?php

class MonitorsControllerTest extends ControllerTestCase
{
    public function testIndexAction()
    {
        $this->dispatch('/index');
        $this->assertController('index');
        $this->assertAction('index');
    }

	public function testAddAction()
	{		
        $this->dispatch('/monitors');
        $this->assertController('monitors');
        $this->assertAction('index');
	}

}

