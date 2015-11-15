hasscms
=======
hasscms

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist hassium/hass-user "*"
```

or add

```
"hassium/hass-user": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \hass\user\AutoloadExample::widget(); ?>```