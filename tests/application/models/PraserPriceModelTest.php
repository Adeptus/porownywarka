<?php

class ParserPriceModelTest extends ControllerTestCase
{
    private $parser;

    public function setUp() {
        parent::setUp();
		
        $this->parser = new Application_Model_ParserPrice();
    }

    public function test_getPrice() {
        $cena = $this->parser->getPrice('Samsung', 'T220');
        $this->assertNotNull($cena);
    }
}

