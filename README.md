# Slim4Locale
A simple middleware for Slim4 framework for using locale in uri.
Usage is very simple, just enable this Middleware (in the Middleware part of your Slim4 Project) with:

```php
<?php

use BrainStorm\Locale4Slim\Locale;

$enabled = true; //or false if disabled
$languages = ['en', 'de', 'it']; //all the languages permitted

$app->add(new Locale($app, $enabled, $languages));
```
After this, all your Slim 4 routes works without the language prefix in routes (because this Middleware check the language before routes are called).
To retrive what language the project is using, just call:
```php
$request->getAttribute('locale');
```
Simple, isn't it?
