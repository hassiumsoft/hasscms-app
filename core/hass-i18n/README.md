hass-i18n
==============
hass-i18n

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist hassium/hass-i18n "*"
```

or add

```
"hassium/hass-i18n": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \hass\i18n\AutoloadExample::widget(); ?>```