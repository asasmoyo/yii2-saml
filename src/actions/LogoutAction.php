<?php

namespace asasmoyo\yii2saml\actions;

/**
 * This action initiate Single Logout process on Identity Provider.
 * @package asasmoyo\yii2saml\actions
 */
class LogoutAction extends BaseAction
{

    /**
     * @var string An url which user will be redirected to after logout.
     */
    public $returnTo;

    /**
     * Initiates Single Logout.
     */
    public function run()
    {
        $this->samlInstance->logout($this->returnTo);
    }

}
