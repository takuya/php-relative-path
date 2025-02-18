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
   * @param $path string target path ( symlink target ).
   * @param $symlink_from string relative path from ( file symlink, relative_to ).
   * @return string relative path.
   */
  function relative_path(string $path, string $symlink_from ):string {
    return RelativePath::getRelativePath($path,$symlink_from);
  }
}