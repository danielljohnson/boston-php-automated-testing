<?php

use PHPUnit_Extensions_Selenium2TestCase_Keys as Keys;

class HelloWorldTest extends PHPUnit_Extensions_Selenium2TestCase {
    
    protected function setUp() {
        $this->setBrowser('chrome');
        $this->setBrowserUrl('http://127.0.0.1/~djohn3/boston-php/hello-world/index.html');
    }
 
    public function testTitleAndParagraph() {
        $this->url('http://127.0.0.1/~djohn3/boston-php/hello-world/index.html');
        
        $this->assertEquals('Automated Functional and Acceptance Testing', $this->title());
        
        $this->assertEquals('What the fox say?', $this->byId('firstParagraph')->text());
    }
    
}

?>