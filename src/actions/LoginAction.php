<?php

namespace asasmoyo\yii2saml\actions;

use Yii;

/**
 * This class provides action for initiating login process using Saml.
 */
class LoginAction extends BaseAction
{
    public $returnUrl = null;

    /**
     * Initiate login process using Saml.
     * @return void
     */
    public function run()
    {
        $this->samlInstance->login($this->returnUrl);
    }

}
