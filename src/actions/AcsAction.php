<?php

namespace asasmoyo\yii2saml\actions;

use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\web\Response;


/**
 * This class handles saml response after login success in Identity Provider.
 */
class AcsAction extends BaseAction
{

    /**
     * This callable will be called when a login process is succesfull. The attributes sent from Identity Provider will be passed to this method.
     * @var callable
     */
    public $successCallback;

    /**
     * After succesfull login process user will be redirected to this url.
     * @var string
     */
    public $successUrl;

    /**
     * It handles acs response from Identity Provider. It will check whether the response is valid or not. If it isn't, an Exception will be thrown. If the response is valid, the successCallback will be called. You can use the callback to create user from attributes sent by Identity Provider or do something else. After that, user will be redirected to successUrl.
     * @return $this|mixed
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function run()
    {
        $this->samlInstance->processResponse();

        $errors = $this->samlInstance->getErrors();
        if (!empty($errors)) {
            $message = 'Saml response error: ' . var_export($errors, true);
            throw new Exception($message);
        }

        if (!is_callable($this->successCallback)) {
            $message = 'Invalid successCallback.';
            throw new InvalidConfigException($message);
        }

        $response = call_user_func($this->successCallback, $this->samlInstance->getAttributes());
        if ($response instanceof Response) {
            return $response;
        }

        return \Yii::$app->response->redirect($this->successUrl);
    }

}
