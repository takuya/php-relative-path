<?php

require_once __DIR__.'/../vendor/autoload.php';
$from = '/etc/nginx/sites-available';
$to   = '/etc/nginx/sites-enabled';
$ret = relative_path( $from,  $to);
var_dump($ret); #=>'../sites-available'
