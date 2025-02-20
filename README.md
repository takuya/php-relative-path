# php-relativePath

Calculate a relative path to path 

[![phpunit](https://github.com/takuya/php-relative-path/actions/workflows/actions.yml/badge.svg)](https://github.com/takuya/php-relative-path/actions/workflows/actions.yml)
[![composer](https://github.com/takuya/php-relative-path/actions/workflows/composer.yml/badge.svg)](https://github.com/takuya/php-relative-path/actions/workflows/composer.yml)


## Get the Relative path.

This package make you get a relative path to a target.

## Equivalent to GNU realpath (Directory to Dir)

This package intended to  same to GNU coreuitls `realpath --relative-to=DIR`.

`realpath` option `--relative-to=DIR` is supposed to be Relative `DIR` to `DIR`.

This package is same to GNU realpath, to calc `DIR to DIR `, not `FILE to FILE`.


## Installing from github.
```

composer config repositories.takuya/php-relative-path vcs https://github.com/takuya/php-relative-path
composer config minimum-stability dev
composer require takuya/php-relative-path
```
## Installing from packagist.
```sh
composer require takuya/php-relative-path
composer install
````
## Usage example.
This package provides a function `relative_path()`  to your composer project. 
```php
<?php

require_once 'vendor/autoload.php';
$ret = relative_path('/etc/nginx/sites-available', '/etc/nginx/sites-enabled');
var_dump($ret);#=>'../sites-available'
```
### example:02 file path 
```php
<?php

require_once 'vendor/autoload.php';
$from = '/etc/nginx/sites-available/example.com';
$to   = '/etc/nginx/sites-enabled/example.com';
$ret = relative_path( dirname($from),  dirname($to));
var_dump($ret.DIRECTORY_SEPARATOR.basename($from));#=>'../sites-available/example.com'
```

Notice : `relative_path` expects DIR. 

## symlink( relative )

`symlink_relative` function is available.

```php
<?php
require_once 'vendor/autoload.php';
$real = '/etc/nginx/sites-available/example.com';
$link  = '/etc/nginx/sites-enabled/example.com';
symlink_relative($link,$real);
```

Relative path is mainly used in symbolic link. so shortcut helper function is provided.

## run tests 
```
composer install
composer dumpautoload
rm tests/sample-data.json
./vendor/bin/phpunit
```

## tests results sample.
```text
Test No.01 :        ./tests/Units relative-to ./tests              is Units
Test No.02 :          tests/Units relative-to ./tests              is Units
Test No.03 :        ./tests/Units relative-to tests                is Units
Test No.04 :          tests/Units relative-to tests                is Units
Test No.05 :              ./tests relative-to ./tests/Units        is ..
Test No.06 :                tests relative-to ./tests/Units        is ..
Test No.07 :              ./tests relative-to tests/Units          is ..
Test No.08 :                tests relative-to tests/Units          is ..
Test No.09 :        /usr/bin/bash relative-to /usr/local/bin       is ../../bin/bash
Test No.10 :        /usr/bin/bash relative-to /usr/local/bin/      is ../../bin/bash
Test No.11 :             /usr/bin relative-to /usr/local/bin/      is ../../bin
Test No.12 :                /usr/ relative-to /usr/local/bin/      is ../..
Test No.13 :                 /usr relative-to /usr/local/bin/      is ../..
Test No.14 :                    / relative-to /usr/local/bin       is ../../..
Test No.15 :         /usr/bin/php relative-to /usr/local/bin/      is ../../bin/php
Test No.16 :        /usr/bin/bash relative-to /usr/local/bin/      is ../../bin/bash

```
You will have doubts about `../../bin/bash` and `/../../php` .

You may shout loud complaint `This package is no use.` But that is bad, Result is correct, intended to be DIR.

`/usr/bin/bash relative-to /usr/local/bin/  is ../../bin/bash` is correct. `DIR to DIR` relative path.

In precisely `/usr/bin/bash` is interpreted as DIR(`/usr/bin/bash/`), and relative path is `../../bin/bash/`.

if you want to create relative symlink use helper function `symlink_relative`.