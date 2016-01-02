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
        'configFileName' => 'saml.php', // OneLogin_Saml config file (Optional)
    ]
]
```

This component requires a ``OneLogin_Saml`` config stored in a php file inside ``@app/config`` folder. The default value for ``configFileName`` is ``saml.php`` so make sure to create this file before. See this [link](https://github.com/onelogin/php-saml/blob/master/settings_example.php) for example configuration.

Usage
-----

This extension provides 4 actions:

1. LoginAction

    This actions will initiate login process to Identity Provider specified in config file. To use this action, just register this action to your actions in your controller.

    ```php
    <?php
    
    class SamlController extends Controller {

        public function actions() {
            return [
                'login' => [
                    'class' => 'asasmoyo\yii2saml\actions\LoginAction'
                ]
            ];
        }

    }
    ```

    Now you can login to your Identity Provider by visiting ``saml/login``.

2. AcsAction

    This action will process saml response sent by Identity Provider after succesfull login. You can register a callback to do some operation like read the attributes sent by Identity Provider and create a new user from that attributes. To use this action just register this action to you controllers's actions.

    ```php
    <?php

    class SamlController extends Controller {

        public function actions() {
            return [
                'acs' => [
                    'class' => 'asasmoyo\yii2saml\actions\AcsAction',
                    'successUrl' => Url::to('site/welcome'), // optional url
                    'successCallback' => [$this, 'callback'], // optional callback
                ]
            ];
        }

        /**
         * @param array $attributes attributes sent by Identity Provider.
         */
        public function callback($attributes) {
            // do something
        }

    }
    ```
    
    **NOTE: Make sure to register the acs action's url to ``AssertionConsumerService`` in Identity Provider.** 

3. MetadataAction

    This action will show metadata of you application in xml. To use this action, just register the action to your controller's action.
    
    ```php
    <?php
    
    class SamlController extends Controller {
        
        public function actions() {
            return [
                'metadata' => [
                    'class' => 'asasmoyo\yii2saml\actions\MetadataAction'
                ]
            ];
        }
        
    }
    ```

4. LogoutAction

    This action will initiate SingleLogout process to Identity Provider. To use this action, just register this action to your controller's actions.
    
    ```php
    <?php
    
    class SamlController extends Controller {
        
        public function actions() {
            return [
                'logout' => [
                    'class' => 'asasmoyo\yii2saml\actions\LogoutAction'
                ]
            ];
        }
        
    }
    ```
    
LICENCE
-------

MIT Licence
