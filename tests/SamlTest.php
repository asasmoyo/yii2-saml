<?php

namespace asasmoyo\yii2saml\tests;

use asasmoyo\yii2saml\Saml;

class SamlTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateInstance()
    {
        $instance = new Saml();
        $this->assertNotEquals($instance, null);
    }

    public function testConfigFromArray()
    {
        $config = require __DIR__ . '/config/saml.php';

        $instance = new Saml([
            'config' => $config,
        ]);

        $this->assertNotEquals($instance->config, []);
        $this->assertEquals($instance->config['sp']['entityId'], 'service-provider');
    }
}
