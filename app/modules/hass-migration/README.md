hass-migration
===================
hass-migration

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist hassium/hass-migration "*"
```

or add

```
"hassium/hass-migration": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \hass\migration\AutoloadExample::widget(); ?>```