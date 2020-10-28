Yii 2 Saml
==========

[![Build Status](https://travis-ci.org/asasmoyo/yii2-saml.svg?branch=master)](https://travis-ci.org/asasmoyo/yii2-saml)

Connect Yii 2 application to a Saml Identity Provider for Single Sign On

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist asasmoyo/yii2-saml "*"
```

or add

```
"asasmoyo/yii2-saml": "*"
```

to the require section of your `composer.json` file.

Configuration
-------------

Register ``asasmoyo\yii2saml\Saml`` to your components in ``config/web.php``.

```php
'components' => [
    'saml' => [
        'class' => 'asasmoyo\yii2saml\Saml',
        'configFileName' => '@app/config/saml.php', // OneLogin_Saml config file (Optional)
    ]
]
```

This component requires a ``OneLogin_Saml`` configuration stored in a php file. The default value for ``configFileName`` is ``@app/config/saml.php`` so make sure to create this file before. This file must returns the ``OneLogin_Saml`` configuration. See this [link](https://github.com/onelogin/php-saml/blob/master/settings_example.php) for example configuration.

```php
<?php

$urlManager = Yii::$app->urlManager;
$spBaseUrl = $urlManager->getHostInfo() . $urlManager->getBaseUrl();

return [
    'sp' => [
        'entityId' => $spBaseUrl.'/saml/metadata',
        'assertionConsumerService' => [
            'url' => $spBaseUrl.'/saml/acs',
        ],
        'singleLogoutService' => [
            'url' => $spBaseUrl.'/saml/sls',
        ],
        'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified',
    ],
    'idp' => [
        'entityId' => 'identity-provider',
        'singleSignOnService' => [
            'url' => 'https://idp.com/sso',
        ],
        'singleLogoutService' => [
            'url' => 'https://idp.com/sls',
        ],
        'x509cert' => '<x509cert string>',
    ],
];
```

**NOTE : As of version 1.6.0 you can directly put your configuration into your component. For example:**

```php
<?php

$urlManager = Yii::$app->urlManager;
$spBaseUrl = $urlManager->getHostInfo() . $urlManager->getBaseUrl();

$config = [
    // some other configuration here

    'components' => [
        'saml' => [
            'class' => 'asasmoyo\yii2saml\Saml',
            'config' => [
                'sp' => [
                    'entityId' => $spBaseUrl.'/saml/metadata',
                    'assertionConsumerService' => [
                        'url' => $spBaseUrl.'/saml/acs',
                    ],
                    'singleLogoutService' => [
                        'url' => $spBaseUrl.'/saml/sls',
                    ],
                    'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:unspecified',
                ],
                'idp' => [
                    'entityId' => 'identity-provider',
                    'singleSignOnService' => [
                        'url' => 'https://idp.com/sso',
                    ],
                    'singleLogoutService' => [
                        'url' => 'https://idp.com/sls',
                    ],
                    'x509cert' => '<x509cert string>',
                ],
            ],
        ]
    ],

    // some other configuration here
];

return $config;

```

Usage
-----

This extension provides 4 actions:

1. LoginAction

    This actions will initiate login process to Identity Provider specified in config file. To use this action, just register this action to your actions in your controller.

    ```php
    <?php

    namespace app\controllers;

    use Yii;
    use yii\web\Controller;
    use yii\helpers\Url;


    class SamlController extends Controller {

        // Remove CSRF protection
        public $enableCsrfValidation = false;

        public function actions() {
            return [
                'login' => [
                    'class' => 'asasmoyo\yii2saml\actions\LoginAction',
                    'returnTo' => Yii::app()->user->returnUrl
                ]
            ];
        }

    }
    ```

    The login method can receive seven optional parameters:

    * `$returnTo` - The target URL the user should be returned to after login..
    * `$parameters` - An array of parameters that will be added to the `GET` in the HTTP-Redirect.
    * `$forceAuthn` - When true the `AuthNRequest` will set the `ForceAuthn='true'`
    * `$isPassive` - When true the `AuthNRequest` will set the `Ispassive='true'`
    * `$strict` - True if we want to stay (returns the url string) False to redirect
    * `$setNameIdPolicy` - When true the AuthNRequest will set a nameIdPolicy element.
    * `$nameIdValueReq` - Indicates to the IdP the subject that should be authenticated.

    Now you can login to your Identity Provider by visiting ``saml/login``.

2. AcsAction

    This action will process saml response sent by Identity Provider after succesfull login. You can register a callback to do some operation like read the attributes sent by Identity Provider and create a new user from that attributes. To use this action just register this action to you controllers's actions.

    ```php
    <?php

    namespace app\controllers;

    use Yii;
    use yii\web\Controller;
    use yii\helpers\Url;


    class SamlController extends Controller {

        // Remove CSRF protection
        public $enableCsrfValidation = false;

        public function actions() {
            return [
                ...
                'acs' => [
                    'class' => 'asasmoyo\yii2saml\actions\AcsAction',
                    'successCallback' => [$this, 'callback'],
                    'successUrl' => Url::to('site/welcome'),
                ]
            ];
        }

        /**
         * @param array $param has 'attributes', 'nameId' , 'sessionIndex', 'nameIdNameQualifier' and 'nameIdSPNameQualifier' from response
         */
        public function callback($param) {
            // do something
            //
            // if (isset($_POST['RelayState'])) {
            // $_POST['RelayState'] - should be returnUrl from login action
            // }
        }
    }
    ```

    **NOTE: Make sure to register the acs action's url to ``AssertionConsumerService`` and the sls actions's url to ``SingleLogoutService`` (if supported) in the Identity Provider.**

3. MetadataAction

    This action will show metadata of you application in xml. To use this action, just register the action to your controller's action.

    ```php
    <?php

        public function actions() {
            return [
                ...
                'metadata' => [
                    'class' => 'asasmoyo\yii2saml\actions\MetadataAction'
                ]
            ];
        }
    ```

4. LogoutAction

    This action will initiate SingleLogout process to Identity Provider. To use this action, just register this action to your controller's actions.

    ```php
    <?php
        $session = Yii::$app->session;
        public function actions() {
            return [
                ...
                'logout' => [
                    'class' => 'asasmoyo\yii2saml\actions\LogoutAction',
                    'returnTo' => Url::to('site/bye'),
                    'parameters' => [],
                    'nameId' => $session->get('nameId'),
                    'sessionIndex' => $session->get('sessionIndex'),
                    'stay' => false,
                    'nameIdFormat' => null,
                    'nameIdNameQualifier' => $session->get('nameIdNameQualifier'),
                    'nameIdSPNameQualifier' => $session->get('nameIdSPNameQualifier'),
                    'logoutIdP' => false, // if you don't want to logout on idp
                ]
            ];
        }
    ```

5. SlsAction

    This action will process saml logout request/response sent by Identity Provider. To use this action just register this action to you controllers's actions.

    ```php
    <?php

        public function actions() {
            ...

            return [
                ...
                'sls' => [
                    'class' => 'asasmoyo\yii2saml\actions\SlsAction',
                    'successUrl' => Url::to('site/bye'),
                    'logoutIdP' => false, // if you don't want to logout on idp
                ]
            ]
        }
    ```

Usage
-----

If the SAMLResponse is rejected, add to the SAML settings the parameter
```
'debug' => true,
```
and the reason will be prompted.


LICENCE
-------

MIT Licence
