<?php

class MonitorsModelTest extends ControllerTestCase
{
    private $model;

    public function setUp()
    {
        parent::setUp();
		
        $this->model = new Application_Model_DbTable_Monitors();
		$this->model->setupDatabaseTest();
		$this->model->deleteMonitor(1);
		$this->model->deleteMonitor(2);
        $this->model->addMonitor(2, 'lolo', 'lolo', 2, 3, 5, 4, 4);
	}

	public function test_addMonitor()
	{
		$this->model->addMonitor(1, 'koko', 'czoko', 2, 3, 5, 4, 4);
        $this->assertNotNull($this->model->getMonitorById('1'));
	}

    public function test_delateMonitor()
    {
		$this->model->deleteMonitor(2);
        $this->assertNull($this->model->getMonitorById('2'));
    }

    public function test_updateMonitor()
    {
        $this->model->updateMonitor(2, 'lolo', 'lolo', 15, 20, 40, 4, 4);
        $monitor = $this->model->getMonitorById('2');
        $this->assertEquals(15, $monitor['Cale']);
    }

    public function test_getMonitorById()
    {
        $monitor = $this->model->getMonitorById('2');  
        $this->assertEquals('lolo', $monitor['nazwa']);      
    }

    public function test_getMonitorByName()
    {
        $monitor = $this->model->getMonitorByName('lolo');  
        $this->assertEquals('lolo', $monitor['nazwa']);      
    }
}

