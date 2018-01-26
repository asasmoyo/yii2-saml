<?php

namespace asasmoyo\yii2saml\actions;

use Yii;
use yii\web\Response;

/**
 * This provides action for displaying metadata for this Service Provider. It uses OneLogin_Saml2_Auth configuration and then generate metadata in xml.
 */
class MetadataAction extends BaseAction
{

    /**
     * Display Service Provider Metadata in xml format.
     * @return void
     */
    public function run()
    {
        Yii::$app->response->format = Response::FORMAT_XML;
        Yii::$app->response->content = $this->samlInstance->getMetadata();
    }
}
