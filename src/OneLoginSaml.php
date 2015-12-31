<?php

namespace asasmoyo\yii2saml;

use yii\base\Object;
use Yii;

/**
 * This class wraps OneLogin_Saml2_Auth class by creating an instance of that class using configurations specified in configFileName variable inside @app/config folder.
 */
class OneLoginSaml extends Object {

    /**
     * The file which contains OneLogin_Saml2_Auth configurations. The file should be located in @app/config folder.
     */
    public $configFileName = 'saml.php';

    /**
     * OneLogin_Saml2_Auth instance.
     */
    private $instance;

    public function __construct($configFileName) {
        $configFile = Yii::getAlias('@app/config') . '/' . $configFileName;
        $config = require($configFile);

        $this->instance = new \OneLogin_Saml2_Auth($config);
    }

    /**
     * Call the login method on OneLogin_Saml2_Auth.
     */
    public function login($returnTo = null, $parameters = array(), $forceAuthn = false, $isPassive = false) {
        return $this->instance->login($returnTo, $parameters, $forceAuthn, $isPassive);
    }

    /**
     * Call the logout method on OneLogin_Saml2_Auth.
     */
    public function logout($returnTo = null, $parameters = array(), $nameId = null, $sessionIndex = null) {
        return $this->instance->logout($returnTo, $parameters, $nameId, $sessionIndex);
    }

    /**
     * Call the processSLO method on OneLogin_Saml2_Auth.
     */
    public function processSLO($keepLocalSession = false, $requestId = null, $retrieveParametersFromServer = false, $cbDeleteSession = null) {
        return $this->instance->proceesSLO($keepLocalSession, $requestId, $retrieveParametersFromServer, $cbDeleteSession);
    }

    /**
     * Call the getAttributes method on OneLogin_Saml2_Auth.
     */
    public function getAttributes() {
        return $this->instance->getAttributes();
    }

     /**
      * Call the getAttribute method on OneLogin_Saml2_Auth.
      */
    public function getAttribute($name) {
        return $this->instance->getAttribute($name);
    }

}
