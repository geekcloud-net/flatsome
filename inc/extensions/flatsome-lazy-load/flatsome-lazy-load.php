<?php

if ( ! class_exists( 'FL_LazyLoad_Images' ) ) :

class FL_LazyLoad_Images {

  protected static $enabled = true;

  static function init() {
    if ( is_admin() ) return; // Disable for admin

    add_action( 'wp_enqueue_scripts', array( __CLASS__, 'add_scripts' ), 99 );
    add_action( 'wp_head', array( __CLASS__, 'setup_filters' ), 99 );
  }

  static function setup_filters() {
    add_filter( 'the_content', array( __CLASS__, 'add_image_placeholders' ), 9999 );
    add_filter( 'post_thumbnail_html', array( __CLASS__, 'add_image_placeholders' ), 11 );
    add_filter( 'get_avatar', array( __CLASS__, 'add_image_placeholders' ), 11 );
    add_filter( 'woocommerce_single_product_image_html', array( __CLASS__, 'add_image_placeholders' ), 9999 );
    add_filter( 'flatsome_woocommerce_get_alt_product_thumbnail', array( __CLASS__, 'add_image_placeholders' ), 11 );
    add_filter( 'flatsome_lazy_load_images', array( __CLASS__, 'add_image_placeholders' ), 9999 );
    add_filter( 'flatsome_woocommerce_single_product_extra_images', array( __CLASS__, 'add_image_placeholders' ), 9999 );
    add_filter( 'woocommerce_single_product_image_thumbnail_html', array( __CLASS__, 'add_image_placeholders' ), 9999 );
    add_filter( 'woocommerce_product_get_image', array( __CLASS__, 'add_image_placeholders' ), 9999 );
  }

  static function add_scripts() {
    global $extensions_uri;

    $theme   = wp_get_theme( get_template() );
    $version = $theme->get( 'Version' );

    wp_enqueue_script(
      'flatsome-lazy',
      $extensions_uri . '/flatsome-lazy-load/flatsome-lazy-load.js',
      array( 'flatsome-js' ),
      $version,
      true
    );
  }

  static function add_image_placeholders( $content ) {
    if ( ! self::is_enabled() )
      return $content;

    // Don't lazyload for feeds, previews, mobile
    if ( is_feed() || is_preview() )
      return $content;

    $matches = array();
    preg_match_all( '/<img[\s\r\n]+.*?>/is', $content, $matches );

    $search = array();
    $replace = array();

    $i = 0;

    foreach ( $matches[0] as $imgHTML ) {
      // don't do the replacement if the image is a data-uri
      if ( ! preg_match( "/src=['\"]data:image/is", $imgHTML ) ) {
        $i++;

        // generate a base64 image string
        $src = self::create_base64_string( $imgHTML );

        // replace the src and add the data-src attribute
        $replaceHTML = '';

        if ( false === strpos( $imgHTML, 'data-src' ) ) {
          $replaceHTML = preg_replace( '/<img(.*?)src=/is', '<img$1src="' . $src . '" data-src=', $imgHTML );
        } else {
          $replaceHTML = preg_replace( '/<img(.*?)src=(["\'](.*?)["\'])/is', '<img$1src="' . $src . '"', $imgHTML );
        }

        $replaceHTML = preg_replace( '/<img(.*?)srcset=/is', '<img$1srcset="" data-srcset=', $replaceHTML );

        // add the lazy class to the img element
        $classes = 'lazy-load';

        if ( preg_match( '/class=["\']/i', $replaceHTML ) ) {
          $replaceHTML = preg_replace( '/class=(["\'])(.*?)["\']/is', 'class=$1' . $classes . ' $2$1', $replaceHTML );
        } else {
          $replaceHTML = preg_replace( '/<img/is', '<img class="' . $classes . '"', $replaceHTML );
        }

        array_push( $search, $imgHTML );
        array_push( $replace, $replaceHTML );
      }
    }

    $search = array_unique( $search );
    $replace = array_unique( $replace );

    $content = str_replace( $search, $replace, $content );

    return $content;
  }

  static function is_enabled() {
    return self::$enabled;
  }

  static function get_image_size( $html ) {
    preg_match_all( '/(height|width)=["\'](.*?)["\']/is', $html, $matches, PREG_PATTERN_ORDER );
    $size = array( 100, 100 );

    foreach ( $matches[1] as $key => $attr ) {
      $value = intval( $matches[2][ $key ] );

      if ( $attr === 'width' ) $size[0] = $value;
      if ( $attr === 'height' ) $size[1] = $value;
    }

    return $size;
  }

  static function create_base64_string( $imgHTML ) {
    list( $width, $height ) = self::get_image_size( $imgHTML );

    $svg = '<svg';
    $svg .= ' viewBox="0 0 ' . $width . ' ' . $height . '"';
    $svg .= ' xmlns="http://www.w3.org/2000/svg"';
    $svg .= '></svg>';

    // For base64 string:
    // return 'data:image/svg+xml;base64,' . base64_encode( $svg );

    return 'data:image/svg+xml,' . rawurlencode( $svg );
  }
}

add_action( 'init', array( 'FL_LazyLoad_Images', 'init' ) );

/**
 * WooCommerce category thumbnails don't have a filter.
 * Remove the original action and add a custom.
 */
function flatsome_woocommerce_subcategory_thumbnail( $category ) {
  ob_start();
  woocommerce_subcategory_thumbnail( $category );
  $thumbnail = ob_get_clean();
  echo FL_LazyLoad_Images::add_image_placeholders( $thumbnail );
}
remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10 );
add_action( 'woocommerce_before_subcategory_title', 'flatsome_woocommerce_subcategory_thumbnail', 10 );

endif;
