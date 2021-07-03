<?php

namespace Tests\Samples;
use Tests\TestCase;
use SystemUtil\Process;

class SamplesTest extends TestCase{
  public function testSampleFiles(){
    $ret = glob(__DIR__.'/../../samples/*.php');
    $files = array_map('realpath',$ret);
    foreach ($files as $file) {
      $body = file_get_contents($file);
      preg_match_all("%\s*#=>\s*'(.+)'\s*$%", $body,$mat);
      if (!$mat){ continue; }
      $expected = $mat[1];
      
      $proc = new Process("php '$file'");
      $proc->run();
      $ret = $proc->getOutput();
      preg_match_all('%"(.+)"$%', $ret,$mat);
      $results = $mat[1];
      foreach ($results as $idx=> $result){
        $this->assertEquals($expected[$idx], $result);
      }
    }
  }

}