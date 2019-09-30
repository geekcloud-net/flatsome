<?php
/**
 * Flatsome Instant Page extension
 *
 * @author     UX Themes
 * @category   Extension
 * @package    Flatsome/Extensions
 * @since      3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

add_action( 'wp_enqueue_scripts', 'flatsome_instant_page' );

if ( ! function_exists( 'flatsome_instant_page' ) ) :

function flatsome_instant_page() {
  global $extensions_uri;

  wp_enqueue_script(
    'flatsome-instant-page',
    $extensions_uri . '/flatsome-instant-page/flatsome-instant-page.js',
    array(),
    '1.2.1',
    true
  );
}

endif;
