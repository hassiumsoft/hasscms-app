hass-app
=============
hass-app

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist hassium/hass-app "*"
```

or add

```
"hassium/hass-app": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \hass\frontend\AutoloadExample::widget(); ?>```