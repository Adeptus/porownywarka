<?php

class ParserSamsungModelTest extends ControllerTestCase
{
    private $parser;

    public function setUp() {
        parent::setUp();
        $this->parser = new Application_Model_ParserSamsung();
    }

    public function test_findMonitor() {
//		$monitor = $this->parser->findMonitor('2443NW');
//        $this->assertNotNull($monitor);
    }
}
