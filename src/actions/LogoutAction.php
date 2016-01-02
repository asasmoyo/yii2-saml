<?php

namespace asasmoyo\yii2saml\actions;

/**
 * This action initiate Single Logout process on Identity Provider.
 * @package asasmoyo\yii2saml\actions
 */
class LogoutAction extends BaseAction
{

    /**
     * Initiates Single Logout.
     */
    public function run()
    {
        $this->samlInstance->logout();
    }

}
