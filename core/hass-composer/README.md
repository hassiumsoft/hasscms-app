hass-composer
=============
hass-composer

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist hassium/hass-composer "*"
```

or add

```
"hassium/hass-composer": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \hass\composer\AutoloadExample::widget(); ?>```