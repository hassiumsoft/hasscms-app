widgets
=======
widgets

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist hassium/hass-widgets "*"
```

or add

```
"hassium/hass-widgets": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \hass\extensions\AutoloadExample::widget(); ?>```