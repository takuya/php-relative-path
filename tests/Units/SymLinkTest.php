<?php

namespace Tests\Units;

use Tests\TestCase;

class SymLinkTest extends TestCase {
  
  public function test_symlink_as_relative() {
    
    $msg = $this->str_rand(10);
    $path = $this->base_path.'/'.$this->str_rand(5).'.zip';
    file_put_contents($path, $msg);
    //
    foreach([true,false] as $flag){
      $sub = $this->base_path;
      foreach (preg_split('|/|', '/a/b/c/d/e') as $item) {
        $sub .= !empty($item) ?  DIRECTORY_SEPARATOR.$item:'';
        ! file_exists($sub) && mkdir($sub, 0777, true);
        $link = $sub.'/'.$this->str_rand(10).'.link';
        $rel = symlink_relative($link,$path,$flag);
        $this->assertEquals($path,realpath($link));
        $this->assertEquals($rel,readlink($link));
        $this->assertEquals(file_get_contents($link),file_get_contents($path));
      }
      
    }
  }
}