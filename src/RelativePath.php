<?php

namespace SystemUtil;



class RelativePath {
  
  protected static function remove_relative_in_middle($path){
    $result = [];
    $sep = '/';

    $path = str_replace(array('/', '\\'), '/', $path);
    $path = preg_split('%/%', $path);
    $path[0]==="" ? array_unshift($path,'/'): null ;
    $path = array_filter($path,'strlen');
    while($ent = array_pop($path)){
      switch($ent){
        case ".": break;
        case "..": array_pop($result);break;
        default: array_unshift($result,$ent);
      }
    }
    $result = join($sep,$result);
    $result = preg_replace("|^/{$sep}|", $sep, $result);
    return $result;
  }
  protected static function dirname($path){
    // dump($path);
    $s = '/';
    $path = preg_replace("|{$s}$|", '', $path);
    $path = str_replace(array('/', '\\'), '/', $path);
    $path = preg_split("|{$s}|", $path);
    array_pop($path);
    // dump($path);
    return join($s, $path);
  }
  protected static function getStringIntersects($strA, $strB){
    $max = (strlen($strA)>=strlen($strB) )?strlen($strA):strlen($strA);
    $str_intersects = '';
    for ($i=0;$i<$max;$i++ ){
      if ( substr($strA,$i,1) == substr($strB,$i,1)){
        $str_intersects=substr($strA,0,$i+1);
        continue;
      }
    }
    return $str_intersects;
    
  }
  
  public static function getRelativePath( $path, $relative_to){
    $rel = null;
    
    $path = self::remove_relative_in_middle($path);
    $relative_to = self::remove_relative_in_middle($relative_to);
  
    $intersects = self::getStringIntersects($path, $relative_to);
    $path = array_filter(preg_split('%/%',preg_replace("|^$intersects|",'',$path)));
    $relative_to = array_filter(preg_split('%/%', preg_replace("|^$intersects|", '', $relative_to)));
  
    $rel = array_merge(array_fill(0, sizeof($relative_to), '..'), $path);
    $rel = join('/',$rel);
    return $rel;
  }

}