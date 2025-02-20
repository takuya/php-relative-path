<?php

namespace Tests\Units;

use Takuya\ProcOpen\ProcOpen;
use Tests\TestCase;
use SystemUtil\RelativePath;

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
  
  protected function checkRealpathExists() {
    $proc = new ProcOpen(['which', 'realpath']);
    $proc->run();
    if( $proc->info->exitcode ) {
      throw new \RuntimeException('sudo apt install realpath / brew install realpath');
    }
    $proc = new ProcOpen(['realpath', '--help']);
    $proc->run();
    if( ! preg_match('/GNU/', $proc->getOutput()) ) {
      throw new \RuntimeException('Please install in PATH  "GNU realpath" of gnu coreutils ');
    }
  }
  
  /**
   * generate test patter use realpath GNU extended.
   */
  protected function generate_testpattern() {
    $sample = __DIR__.'/../sample-path.json';
    if( ! file_exists($sample) ) {
      // --relative-to=DIR
      $relative_pattern = [
        ['./tests', './tests/Units'],
        ['./tests', 'tests/Units'],
        ['tests', './tests/Units'],
        ['tests', 'tests/Units'],
        ['./tests/Units', './tests'],
        ['./tests/Units', 'tests'],
        ['tests/Units', './tests'],
        ['tests/Units', 'tests'],
        ['/usr/local/bin', '/usr/bin/bash'],
        ['/usr/local/bin/', '/usr/bin/bash'],
        ['/usr/local/bin/', '/usr/bin'],
        ['/usr/local/bin/', '/usr/'],
        ['/usr/local/bin/', '/usr'],
        ['/usr/local/bin', '/'],
        ['/usr/local/bin/', '/usr/bin/php8'],
        ['/usr/local/bin/', '/usr/bin/bash'],
        ['/usr/bin/bash', '/usr/local/sbin'],
        ['/tmp/sample-app', '/tmp/sample-bap'],
      ];
      $patterns = [];
      foreach ($relative_pattern as $pattern) {
        $proc = new ProcOpen("realpath --relative-to={$pattern[0]} ${pattern[1]}");
        $proc->run();
        $patterns[] = [$pattern[0], $pattern[1], trim($proc->getOutput())];
      }
      echo PHP_EOL;
      echo $str = json_encode($patterns, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
      file_put_contents($sample, $str);
    }
    $str = file_get_contents($sample);
    $this->patterns = json_decode($str);
  }
  
  public function testSameStringInDirName() {
    $from = '/etc/nginx/sites-available';
    $to = '/etc/nginx/sites-enabled';
    $rel = RelativePath::getRelativePath($from, $to);
    $this->assertEquals('../sites-available', $rel);
  }
  
  public function testRealPathCommand() {
    
    foreach ($this->patterns as $idx => $pattern) {
      
      $pattern = $this->patterns[$idx];
      printf("\nTest No.%02d : %20s relative-to %-20s is %-20s", $idx + 1, $pattern[1], $pattern[0], $pattern[2]);
      //
      $rel = RelativePath::getRelativePath($pattern[1], $pattern[0]);
      $this->assertEquals($pattern[2], $rel);
    }
    printf("\r\n");
  }
}