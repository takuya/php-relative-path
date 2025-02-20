<?php

use SystemUtil\RelativePath;

/**
 * Function RelativePath
 * @package SystemUtil
 * @author  takuya
 * @link  https://github.com/takuya/php-relative-path
 * @license GNU LGPL, Attribution required for commercial implementations, requested for everything else.
 * @since  2021-06-29
 */

if ( !function_exists('relative_path')){
  /**
   * @param $target_dir string target path ( symlink target ).
   * @param $symlink_from_dir string relative path from ( --relative_to=DIR ).
   * @return string relative path.
   */
  function relative_path( string $target_dir, string $symlink_from_dir ):string {
    return RelativePath::getRelativePath($target_dir, $symlink_from_dir);
  }
}