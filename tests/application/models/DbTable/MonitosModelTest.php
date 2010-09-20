<?php

class MonitorsModelTest extends ControllerTestCase
{
    private $model;

    public function setUp() {
        parent::setUp();
		
        $this->model = new Application_Model_DbTable_Monitors();
        $this->model->setupDatabaseTest();
        $this->model->deleteMonitor(1);
        $this->model->deleteMonitor(2);
        $this->model->deleteMonitor(3);
        $this->model->deleteMonitor(4);
        $this->model->addMonitor(2, 'lolo', 'lolo', 22, 3, 5, '1 100 x 1 500', '20000:1 (1000:1)');
        $this->model->addMonitor(3, 'bolo', 'koko', 23, 3, 5, '1 200 x 2 222', '25000:1 (1000:1)');
	}

	public function test_addMonitor() {
		$this->model->addMonitor(1, 'koko', 'czoko', 2, 3, 5, 4, 4);
        $this->assertNotNull($this->model->getMonitorById('1'));
	}

    public function test_addMonitorWithDuplicateName() {
		$this->model->addMonitor(4, 'muuu', 'lolo', 2, 3, 5, 4, 4);
        $this->assertNull($this->model->getMonitorById('4'));
    }

    public function test_delateMonitor() {
		$this->model->deleteMonitor(2);
        $this->assertNull($this->model->getMonitorById('2'));
    }

    public function test_updateMonitor() {
        $this->model->updateMonitor(2, 'lolo', 'lolo', 15, 20, 40, 4, 4);
        $monitor = $this->model->getMonitorById('2');
        $this->assertEquals(15, $monitor['Cale']);
    }

    public function test_getMonitorById() {
        $monitor = $this->model->getMonitorById('2');  
        $this->assertEquals('lolo', $monitor['nazwa']);      
    }

    public function test_getMonitorByName() {
        $monitor = $this->model->getMonitorByName('lolo');  
        $this->assertEquals('lolo', $monitor['nazwa']);      
    }

    /*wyszukiwanie po parametrach:*/
    
    public function test_getIdsByParametersWithOneParameter() {
        $monitors_id = $this->model->getIdsByParameters('Jasnosc', 3);
        $this->assertEquals(2, $monitors_id[0]);        
    }  

    public function test_getIdsByParametersWithWrongParameter() {
        $this->assertNull($this->model->getIdsByParameters('Jasnosc', '55555'));
    }  

    public function test_getIdsByParametersWithSecondParameterMin() {
        $monitors_id = $this->model->getIdsByParameters('Rozdzielczosc', '20000:1 (1000:1)');
        $this->assertEquals(2, $monitors_id[0]);
        $this->assertEquals(3, $monitors_id[1]);        
    }   

    public function test_getIdsByParametersWithSecondParameterMax() {
        $monitors_id = $this->model->getIdsByParameters('Kontrast', null, '1 200 x 2 222');
        $this->assertEquals(2, $monitors_id[0]);
        $this->assertEquals(3, $monitors_id[1]);        
    }   

    public function test_getIdsByParametersWithParameterNotFind() {
        $this->assertNull($this->model->getIdsByParameters('Jasnosc', '4'));
    } 

    public function test_getIdsByParametersWithSecondParameterBetween() {
        $monitors_id = $this->model->getIdsByParameters('Kontrast', '1 100 x 1 500', '1 200 x 2 222');
        $this->assertEquals(2, $monitors_id[0]);
        $this->assertEquals(3, $monitors_id[1]);        
    }  

}

