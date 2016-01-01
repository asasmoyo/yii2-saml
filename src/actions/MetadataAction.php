<?php

namespace asasmoyo\yii2saml\actions;

use yii\base\Action;
use Yii;

/**
 * This provides action for displaying metadata for this Service Provider. It uses OneLogin_Saml2_Auth configuration and then generate metadata in xml.
 */
class MetadataAction extends Action {

    /**
     * This variable should be the component name of asasmoyo\yii2saml\Saml.
     * @var string
     */
    public $samlInstanceName = 'saml';

    /**
     * This variable hold the instance of asasmoyo\yii2saml\Saml.
     * @var asasmoyo\yii2saml\Saml
     */
    private $samlInstance;

    public function init() {
        parent::init();

        $this->samlInstance = Yii::$app->get($this->samlInstanceName);
    }

    public function run() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        echo $this->samlInstance->getMetadata();
    }

}
