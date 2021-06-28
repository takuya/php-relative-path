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
   * @param $path string target path.
   * @param $relative_to string relative path from.
   * @return string relative path.
   */
  function relative_path( $path, $relative_to ):string {
    return RelativePath::getRelativePath($path,$relative_to);
  }
}