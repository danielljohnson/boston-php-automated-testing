<?php

class GridTest extends PHPUnit_Extensions_Selenium2TestCase {
    
    protected function setUp() {
        $this->setBrowser('chrome');
        $this->setBrowserUrl('http://127.0.0.1/~djohn3/boston-php/demo/grid.html');
    }
 
    public function testPageTitle() {
        $this->url('http://127.0.0.1/~djohn3/boston-php/demo/grid.html');
        
        $this->assertEquals('Grid', $this->title());
    }
    
    public function testLoadGrid() {
        $this->url('http://127.0.0.1/~djohn3/boston-php/demo/grid.html');
        
        // wait for grid to load
        $this->waitUntil(function() {
            $elements = $this->elements($this->using('css selector')->value('tbody tr'));
            
            return (count($elements) === 3) ? true : null;
        }, 3000);
        
        // test some sample data from grid
        $this->assertEquals('1', $this->byCssSelector('tbody tr:nth-child(1) td:nth-child(1)')->text());
        $this->assertEquals('Ella', $this->byCssSelector('tbody tr:nth-child(2) td:nth-child(2)')->text());
        $this->assertEquals('Johnson', $this->byCssSelector('tbody tr:nth-child(3) td:nth-child(3)')->text());
    }
    
    public function testRefreshGrid() {
        $this->url('http://127.0.0.1/~djohn3/boston-php/demo/grid.html');
        
        // wait for grid to load
        $this->waitUntil(function() {
            $elements = $this->elements($this->using('css selector')->value('tbody tr'));
            
            return (count($elements) === 3) ? true : null;
        }, 3000);
        
        // click refresh link
        $this->byId('refreshGrid')->click();
        
        // wait for new data to be loaded into grid
        $this->waitUntil(function() {
            $elements = $this->elements($this->using('css selector')->value('tbody tr'));
            
            return (count($elements) === 4) ? true : null;
        }, 3000);
        
        // test some sample data from grid
        $this->assertEquals('1', $this->byCssSelector('tbody tr:nth-child(1) td:nth-child(1)')->text());
        $this->assertEquals('Ella', $this->byCssSelector('tbody tr:nth-child(2) td:nth-child(2)')->text());
        $this->assertEquals('Johnson', $this->byCssSelector('tbody tr:nth-child(3) td:nth-child(3)')->text());
        $this->assertEquals('4', $this->byCssSelector('tbody tr:nth-child(4) td:nth-child(1)')->text());
    }
    
}

?>