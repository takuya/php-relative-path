<?php

namespace Tests\Units;

use Tests\TestCase;
use SystemUtil\Process;
use SystemUtil\RelativePath;
use function PHPUnit\Framework\assertGreaterThanOrEqual;

class RelativePathTest extends TestCase {
  
  /**
   * @var string[]
   */
  private $patterns;
  
  protected function setUp():void {
    //
    parent::setUp();
    //
    $this->checkRealpathExists();
    $this->generate_testpattern();
  }
  protected function checkRealpathExists(){
    $proc = new Process('which realpath');
    $proc->run();
    if (!$proc->isSuccessful()){
      throw new \RuntimeException('sudo apt install realpath / brew install realpath');
    }
    $proc = new Process('realpath --help ');
    $proc->run();
    if (! preg_match('/GNU/', $proc->getOutput())){
      throw new \RuntimeException('Please install in PATH  "GNU realpath" of gnu coreutils ');
    }
  }
  
  /**
   * generate test patter use realpath GNU extended.
   */
  protected function generate_testpattern(){
    $sample = __DIR__.'/../sample-path.json';
    if ( !file_exists( $sample )){
      $relative_pattern = [
        ['./tests','./tests/Units'],
        ['./tests','tests/Units'],
        ['tests','./tests/Units'],
        ['tests','tests/Units'],
        ['./tests/Units','./tests'],
        ['./tests/Units','tests'],
        ['tests/Units','./tests'],
        ['tests/Units','tests'],
        ['/usr/local/bin', '/usr/bin/bash'],
        ['/usr/local/bin/', '/usr/bin/bash'],
        ['/usr/local/bin/', '/usr/bin'],
        ['/usr/local/bin/', '/usr/'],
        ['/usr/local/bin/', '/usr'],
        ['/usr/local/bin', '/'],
        ['/usr/local/bin/', '/usr/bin/php'],
        ['/usr/local/bin/', '/usr/bin/bash'],
      ];
      $patterns = [];
      foreach ($relative_pattern as $pattern) {
        $proc = new Process("realpath --relative-to=${pattern[0]} ${pattern[1]}");
        $proc->run();
        $patterns[]=[$pattern[0], $pattern[1],trim($proc->getOutput())];
      }
      echo PHP_EOL;
      echo     $str = json_encode($patterns, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
      file_put_contents($sample,$str);
    }
    
    
    $str = file_get_contents($sample);
    $this->patterns=json_decode($str);
  
  
  }
  
  public function testRealPathCommand(){
    
    // for ($idx=13;$idx<sizeof($this->patterns);$idx++){
    foreach ($this->patterns as $idx => $pattern) {
    // for ($idx=0;$idx<sizeof($this->patterns);$idx++){
      $pattern = $this->patterns[$idx];
      printf("\nTest No.%02d : %20s relative-to %-20s is %-20s", $idx+1, $pattern[1],$pattern[0],$pattern[2]);
      
      $rel = RelativePath::getRelativePath($pattern[1],$pattern[0]);
      $this->assertEquals($pattern[2], $rel);
      
    }
    // foreach ($this->patterns as $idx => $pattern) {
    // }
  }
}