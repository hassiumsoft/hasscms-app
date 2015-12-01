hass-theme
===============
hass-theme

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist hassium/hass-theme "*"
```

or add

```
"hassium/hass-theme": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \hass\theme\AutoloadExample::widget(); ?>```