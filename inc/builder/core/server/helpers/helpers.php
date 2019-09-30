<?php

/**
 * Get enqueued assets that is dependant on gridsome.
 */
function ux_builder_deps( $all, $handler, $only_handle = true ) {
  $deps = array();

  foreach ( $all->queue as $key => $handle ) {
    $is_registered = array_key_exists( $handle, $all->registered );
    $is_string     = is_string( $all->registered[ $handle ]->src );
    $is_dep        = in_array( $handler, $all->registered[ $handle ]->deps, true );
    if ( $is_registered && $is_string && $is_dep ) {
      if ( $only_handle ) array_push( $deps, $handle );
      else array_push( $deps, $all->registered[ $handle ]->src );
    }
  }

  return $deps;
}
