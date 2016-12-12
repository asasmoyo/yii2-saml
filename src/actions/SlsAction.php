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
        $this->samlInstance->processSLO();

        $errors = $this->samlInstance->getErrors();
        if (!empty($errors)) {
            $message = 'Logout error: ' . implode(",", $errors);
            if ($this->samlInstance->isDebugActive()) {
                $reason = $this->samlInstance->getLastErrorReason();
                if (!empty($reason)) {
                    $message .= "\n".$reason;
                }
            }
            throw new Exception($message);
        }
        return \Yii::$app->response->redirect($this->returnTo);
    }
}
