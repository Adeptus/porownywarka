<?php

class UserControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

	public $bootstrap = '/www/porownywarka/application/controllers/MonitorsController.php';

    public function setUp()
    {
	    $this->bootstrap;
		parent::setUp();
	}
	
	public function testCallWithoutActionShouldPullFromIndexAction()
    {
        $this->dispatch('/user');
        $this->assertController('user');
        $this->assertAction('index');
    }
	     
}
?>
