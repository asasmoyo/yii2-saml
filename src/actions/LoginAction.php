<?php

namespace asasmoyo\yii2saml\actions;

use Yii;

/**
 * This class provides action for initiating login process using Saml.
 */
class LoginAction extends BaseAction
{
    /**
     * @param string|null   $returnTo   The target URL the user should be returned to after login.
     */
    public $returnTo = null;

    /**
     * @param array $parameters   Extra parameters to be added to the GET
     */
    public $parameters = [];

    /**
     * @param bool  $forceAuthn When true the AuthNRequest will set the ForceAuthn='true'
     */
    public $forceAuthn = null;

    /**
     * @param bool  $isPassive    When true the AuthNRequest will set the Ispassive='true'
     */
    public $isPassive = null;

    /**
     * @param bool  $stay   True if we want to stay (returns the url string) False to redirect
     */
    public $stay = null;

    /**
     * @param bool  $setNameIdPolicy    When true the AuthNRequest will set a nameIdPolicy element
     */
    public $setNameIdPolicy = null;

    /**
     * @param string    $nameIdValueReq   Indicates to the IdP the subject that should be authenticated
     */

    public $nameIdValueReq = null;


    /**
     * Initiate login process using Saml.
     * @return void
     */
    public function run()
    {
        $this->samlInstance->login($this->returnTo, $this->parameters, $this->forceAuthn, $this->isPassive, $this->stay, $this->setNameIdPolicy, $this->nameIdValueReq);
    }

}
