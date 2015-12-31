<?php

namespace asasmoyo\yii2saml;

class SamlTest extends \PHPUnit_Framework_TestCase {

    public function testCreateInstance() {
        $instance = new Saml();
        $this->assertNotEquals($instance, null);
    }

}
