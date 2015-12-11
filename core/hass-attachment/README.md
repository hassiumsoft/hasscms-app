hass-attachment
====================
hass-attachment

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist hassium/hass-attachment "*"
```

or add

```
"hassium/hass-attachment": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \hass\attachment\AutoloadExample::widget(); ?>```