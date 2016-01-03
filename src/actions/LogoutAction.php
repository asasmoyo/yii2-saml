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
        // Check wether SAMLResponse is present. If it is, we process the response and redirect the user to returnTo.
        $response = \Yii::$app->request->post('SAMLResponse');
        if ($response) {
            $this->samlInstance->processResponse();
            return \Yii::$app->response->redirect($this->returnTo);
        }

        // if it isn't, logout the user on Yii 2 and Identity Provider.
        \Yii::$app->user->logout();
        $this->samlInstance->logout($this->returnTo);
    }

}
