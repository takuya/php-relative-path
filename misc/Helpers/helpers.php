<?php
if( ! function_exists('dd') ) {
  function dd( ...$args ) {
    //var_dump(debug_backtrace());
    dump(...$args);
    exit;
  }
}
if( ! function_exists('dump') ) {
  function dump( ...$args ) {
    echo "\n";
    foreach (func_get_args() as $e) {
      var_dump($e);
    }
  }
};;
if( ! function_exists('ascii_letters') ) {
  function ascii_letters() {
    $ascii_letters = array_map(function ( $e ) { return chr($e); }, array_merge(range(65, 90), range(97, 122)));
    
    return $ascii_letters;
  }
}
