<?php

namespace asasmoyo\yii2saml\actions;

use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\web\Response;


/**
 * This class handles saml logout request and response.
 */
class SlsAction extends BaseAction
{
    /**
     * After succesfull logout process user will be redirected to this url.
     * @var string
     */
    public $successUrl;

    /**
     * It handles sls logout request/response from Identity Provider. It will check whether is valid or not. If it isn't, an Exception will be thrown. If is valid, the successCallback will be called. You can use the callback to create user from attributes sent by Identity Provider or do something else. After that, user will be redirected to successUrl.     * @return $this|mixed
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function run()
    {
        // Check wether SAMLRequest/SAMLResponse is present. If it is, we process the logout request/response and redirect the user to returnTo.
        $request = \Yii::$app->request->get('SAMLRequest');
        $response = \Yii::$app->request->get('SAMLResponse');
        if ($request || $response) {
            $this->samlInstance->processSLO();
            return \Yii::$app->response->redirect($this->returnTo);
        }
    }
}
