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
    public $returnTo;                   //The target URL the user should be returned to after logout.
    public $parameters;                 //Extra parameters to be added to the GET
    public $nameId;                     //The NameID that will be set in the LogoutRequest.
    public $sessionIndex;               //The SessionIndex (taken from the SAML Response in the SSO process).
    public $stay;                       //True if we want to stay (returns the url string) False to redirect
    public $nameIdFormat;               //The NameID Format will be set in the LogoutRequest.
    public $nameIdNameQualifier;        //The NameID NameQualifier will be set in the LogoutRequest.
    public $nameIdSPNameQualifier;

    /**
     * Initiates Logout.
     */
    public function run()
    {
        // logout the user on Yii 2 and Identity Provider.
        \Yii::$app->user->logout();
        $this->samlInstance->logout($this->returnTo,$this->parameters,$this->nameId,$this->sessionIndex,$this->stay,$this->nameIdFormat,$this->nameIdNameQualifier,$this->nameIdSPNameQualifier);
    }

}
