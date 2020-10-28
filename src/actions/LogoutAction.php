<?php

namespace asasmoyo\yii2saml\actions;

/**
 * This action initiate logout process on Identity Provider.
 * @package asasmoyo\yii2saml\actions
 */
class LogoutAction extends BaseAction
{

    /**
     * @param string|null $returnTo            The target URL the user should be returned to after logout.
     */
    public $returnTo = null;

    /**
     * @param array       $parameters          Extra parameters to be added to the GET
     */
    public $parameters = [];

    /**
     * @param string|null $nameId              The NameID that will be set in the LogoutRequest.
     */
    public $nameId = null;

    /**
     * @param string|null $sessionIndex        The SessionIndex (taken from the SAML Response in the SSO process).
     */
    public $sessionIndex = null;

    /**
     * @param bool        $stay                True if we want to stay (returns the url string) False to redirect
     */
    public $stay = false;

    /**
     * @param string|null $nameIdFormat        The NameID Format will be set in the LogoutRequest.
     */
    public $nameIdFormat = null;

    /**
     * @param string|null $nameIdNameQualifier The NameID NameQualifier will be set in the LogoutRequest.
     */
    public $nameIdNameQualifier = null;

    /**
     * @param string|null $nameIdSPNameQualifier
     */
    public $nameIdSPNameQualifier = null;

    /**
     * true if you want to logout on Identity Provider too.
     * @param bool        $logoutIdP
     */
    public $logoutIdP = true;

    /**
     * Initiates Logout.
     */
    public function run()
    {
        // logout the user on Yii 2
        \Yii::$app->user->logout();

        // and logout user on Identity Provider
        if ($this->logoutIdP == true) {
            $this->samlInstance->logout($this->returnTo, $this->parameters, $this->nameId, $this->sessionIndex, $this->stay, $this->nameIdFormat, $this->nameIdNameQualifier, $this->nameIdSPNameQualifier);
        }
    }
}
