hass-plugin
===========
hass-plugin

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist hassium/hass-plugin "*"
```

or add

```
"hassium/hass-plugin": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \hass\module\AutoloadExample::widget(); ?>```