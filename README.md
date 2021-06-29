# php-relativePath

Calculate a relative path to path 

![<CircleciTest>](https://circleci.com/gh/takuya/php-relative-path.svg?style=svg)

## Get the Relative path.

This package make you get a relative path to a target.

## Equivalent to GNU realpath 

This package intended to  same to GNU coreuitls `realpath --relative-to`.

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
This package will add a function `relative_path()`  to your composer project. 
```php
<?php

require_once 'vendor/autoload.php';
$ret = relative_path('/usr/bin/env', '/usr/bin/bash');
var_dump($ret);
```


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