<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {
  
  protected function str_rand( $length = 16 ):string {
    return substr(
      str_shuffle(
        str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)))),
      1,
      $length);
  }
  
  protected function temp_dir() {
    $tmp = sys_get_temp_dir();
    $ret = $this->str_rand(8);
    $temp_dir = $tmp.DIRECTORY_SEPARATOR.$ret;
    mkdir($temp_dir, 0777, true);
    register_shutdown_function(function () use ( $temp_dir ) {
      proc_open(['rm', '-rf', $temp_dir], [], $io);
    });
    
    return $temp_dir;
  }
  
  protected string $base_path;
  
  protected function setUp():void {
    parent::setUp();
    $this->base_path = $this->temp_dir();
  }
}