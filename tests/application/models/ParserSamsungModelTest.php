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

    public function test_functionRemoveAllWrongValueFromTable() {
        $tableToCheck = array('Kontrast' => 'sraka na bosaka 10 0 0:1 (032 lo l)', 'Rozdzielczość' => '1 1 1 1      x 2522');
        $correctTable = $this->parser->removeAllWrongValueFromTable($tableToCheck);
        $this->assertEquals('1000', $correctTable['Kontrast']);
    }   
}
