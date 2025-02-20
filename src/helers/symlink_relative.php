<?php

use SystemUtil\RelativePath;

/**
 * Function RelativePath
 * @package SystemUtil
 * @author  takuya
 * @link    https://github.com/takuya/php-relative-path
 * @license GNU LGPL, Attribution required for commercial implementations, requested for everything else.
 * @since   2025-02-20
 */
if( ! function_exists('symlink_relative') ) {
  /**
   * @param $link   string target path ( symlink target ).
   * @param $target string relative path from ( file symlink, relative_to ).
   * @return bool|string relative path if successfully symlink created. false if failed.
   */
  function symlink_relative( string $link, string $target, $gnu_relave_dir_flag = false ):bool|string {
    if( ! $gnu_relave_dir_flag && dirname($target) == dirname($link) ) {
      return symlink($relative = '.'.DIRECTORY_SEPARATOR.basename($target), $link) ? $relative : false;
    }
    $relative = RelativePath::getRelativePath(
      is_dir($target) ? $target : dirname($target),
      is_dir($link) ? $link : dirname($link),
      $gnu_relave_dir_flag);
    is_file($target) && $relative = $relative.DIRECTORY_SEPARATOR.basename($target);
    
    return symlink($relative, $link) ? $relative : false;
  }
}