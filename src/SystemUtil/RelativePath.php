<?php

namespace SystemUtil;

/**
 * Class RelativePath
 * @package SystemUtil
 * @author  takuya
 * @link  https://github.com/takuya/php-relative-path
 * @license GNU LGPL, Attribution required for commercial implementations, requested for everything else.
 * @since  2021-06-29
 */

class RelativePath {
  
  protected static function remove_relative_in_middle($path):string{
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
  protected static function dirname($path):string {
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
    $max = (strlen($strA)>=strlen($strB) )?strlen($strA):strlen($strB);
    $str_intersects = '';
    for ($i=0,$a=true;$i<$max;$i++ ){
      if ( $a = substr($strA,$i,1) == substr($strB,$i,1) && $a ){
        $str_intersects =substr($strA,0,$i+1);
        continue;
      }
    }
    return $str_intersects;
  }
  /**
   * @param $path string target path.
   * @param $relative_to string relative path from.
   * @return string relative path.
   */
  public static function getRelativePath( $path, $relative_to,$gnu_realpath_compat=true):string {
    $path = self::remove_relative_in_middle($path);
    $relative_to = self::remove_relative_in_middle($relative_to);
  
    $str_intersects = self::getStringIntersects($path, $relative_to);
    if ($gnu_realpath_compat){
      $pos = strrpos($str_intersects, '/');
      $str_intersects = $pos ? substr($path,0,$pos) : $str_intersects ;
    }
  
    $path = array_filter(preg_split('%/%',preg_replace("|^$str_intersects|",'',$path)));
    $relative_to = array_filter(preg_split('%/%', preg_replace("|^$str_intersects|", '', $relative_to)));
    $rel = array_merge(array_fill(0, sizeof($relative_to), '..'), $path);
    $rel = join('/',$rel);
    return $rel;
  }

}