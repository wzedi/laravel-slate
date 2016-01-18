laravel-slate
================
Generate tripit/slate documentation directly from Laravel controllers.

Install
------

```json
// composer.json
"require": {
    "cadreworks/laravel-slate": "dev-master"
}
```

Usage
-----
* Add the the document generator as middleware to bootstrap/app.php for Lumen or app/Http/Kernel.php for Laravel

```php
$app->middleware([ 
    CadreWorks\LaravelSlate\DocumentGenerator::class,
]);
```

* Configure the generator output path. If no path is configured the default behaviour sends output to the debug Log. Set the path in .env

```php
LARAVEL_SLATE_PATH=/full/path/to/slate/include/dir
```

* Configure slate to read the generated files. In the source/index.md file:

```php
includes:
    - relative/path/to/include/dir
```

Requirements:
-------------
Laravel 5.1

License:
--------
MIT

Author:
-------
Warrick Zedi
