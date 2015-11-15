hass-page
==============
hass-page

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist hassium/hass-page "*"
```

or add

```
"hassium/hass-page": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \hass\page\AutoloadExample::widget(); ?>```