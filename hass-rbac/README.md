hass-rbac
==============
hass-rbac

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist hassium/hass-rbac "*"
```

or add

```
"hassium/hass-rbac": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \hass\rbac\AutoloadExample::widget(); ?>```