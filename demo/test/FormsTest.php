<?php

use PHPUnit_Extensions_Selenium2TestCase_Keys as Keys;

class FormsTest extends PHPUnit_Extensions_Selenium2TestCase {
    
    protected function setUp() {
        $this->setBrowser('chrome');
        $this->setBrowserUrl('http://127.0.0.1/~djohn3/boston-php/demo/forms.html');
    }
 
    public function testPageTitle() {
        $this->url('http://127.0.0.1/~djohn3/boston-php/demo/forms.html');
        
        $this->assertEquals('Forms', $this->title());
    }
    
    public function testDisplayName() {
        $this->url('http://127.0.0.1/~djohn3/boston-php/demo/forms.html');
        
        $firstNameField = $this->byName('firstName');
        $firstNameField->value('Dan');
        $this->assertEquals('Dan', $firstNameField->value());
        
        $lastNameField = $this->byName('lastName');
        $lastNameField->value('Johnson');
        $this->assertEquals('Johnson', $lastNameField->value());
        
        $this->byId('nameForm')->submit();
        
        $this->assertEquals('Dan Johnson', $this->byId('displayName')->text());
    }
    
    public function testDisplayColor() {
        $this->url('http://127.0.0.1/~djohn3/boston-php/demo/forms.html');
        
        $this->select($this->byName('color'))->selectOptionByValue("red");
        
        //$this->byId('colorForm')->submit();
        
        $this->keys(Keys::ENTER);
        
        $this->assertEquals('red', $this->byId('displayColor')->text());
    }
    
    public function testEmailValidation() {
        $this->url('http://127.0.0.1/~djohn3/boston-php/demo/forms.html');
        
        // submit empty form
        $this->byId('contactForm')->submit();
        
        // check that we are still on the forms page
        $this->assertEquals('Forms', $this->title());
        
        // wait for error box to fade in
        $this->waitUntil(function() {
            $script = 'return $("#formErrors").is(":animated");';
        
            $result = $this->execute(array(
                'script' => $script,
                'args'   => array()
            ));
            
            return ($result === false) ? true : null;
        }, 4000);
        
        // check length of validation messages
        $elements = $this->elements($this->using('css selector')->value('.alertContent span'));
        $this->assertEquals(1, count($elements));
        
        // check content of first validation message
        $firstError = $this->byXPath('//div[@class="alertContent"]/span[1]')->text();
        $this->assertEquals('Please fill in all required fields!', $firstError);
    }
    
}

?>