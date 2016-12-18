<?php

namespace asasmoyo\yii2saml\actions;

/**
 * This action initiate logout process on Identity Provider.
 * @package asasmoyo\yii2saml\actions
 */
class LogoutAction extends BaseAction
{

    /**
     * @var string An url which user will be redirected to after logout.
     */
    public $returnTo;

    /**
     * Initiates Logout.
     */
    public function run()
    {
        // logout the user on Yii 2 and Identity Provider.
        \Yii::$app->user->logout();
        $this->samlInstance->logout($this->returnTo);
    }

}
