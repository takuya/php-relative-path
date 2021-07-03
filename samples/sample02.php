<?php


require_once __DIR__.'/../vendor/autoload.php';

$from = '/etc/nginx/sites-available/example.com';
$to   = '/etc/nginx/sites-enabled/example.com';
$ret = relative_path( dirname($from),  dirname($to));
var_dump($ret.DIRECTORY_SEPARATOR.basename($from));#=>'../sites-available/example.com'

