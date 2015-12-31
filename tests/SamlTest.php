<?php

class SamlTest extends PHPUnit_Framework_TestCase {

    public function testCreateInstance() {
        $instance = new \asasmoyo\yii2saml\Saml();
        $this->assertNotEquals($instance, null);
    }

}
