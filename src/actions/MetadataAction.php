<?php

namespace asasmoyo\yii2saml\actions;

use yii\base\Action;
use Yii;

/**
 * This provides action for displaying metadata for this Service Provider. It uses OneLogin_Saml2_Auth configuration and then generate metadata in xml.
 */
class MetadataAction extends BaseAction {

    /**
     * Display Service Provider Metadata in xml format.
     * @return void
     */
    public function run() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        echo $this->samlInstance->getMetadata();
    }

}
