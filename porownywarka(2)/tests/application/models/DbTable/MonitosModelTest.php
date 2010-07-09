<?php

class MonitorsModelTest extends ControllerTestCase
{
    private $gateway_user;

    public function setUp()
    {
        parent::setUp();
		
        $this->gateway_user = new Application_Model_DbTable_Monitory();
		$this->gateway_user->setupDatabaseTest();
	}

	public function test_addAndDeleteMonitor()
	{
        $this->assertNull($this->gateway_user->getMonitor('1'));
		$this->gateway_user->addMonitor(1, 'koko', 'czoko', 2, 3, 5, 4, 4);
        $this->assertNotNull($this->gateway_user->getMonitor('1'));
		$this->gateway_user->deleteMonitor(1);
	}
}

