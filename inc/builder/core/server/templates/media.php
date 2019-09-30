<?php

/**
* @global string    $hook_suffix
* @global WP_Screen $current_screen
* @global WP_Locale $wp_locale
* @global string    $pagenow
* @global string    $wp_version
*/

/** WordPress Administration Bootstrap */
require_once( ABSPATH . 'wp-admin/admin.php' );

wp_user_settings();
wp_enqueue_media();
wp_enqueue_style( 'colors' );
wp_enqueue_style( 'ie' );
wp_enqueue_script( 'utils' );
wp_enqueue_script( 'svg-painter' );

global $hook_suffix, $current_screen, $wp_locale, $pagenow;

?><!DOCTYPE html>
<html>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <script>
    var ajaxurl = "<?php echo admin_url( 'admin-ajax.php', 'relative' ); ?>",
    pagenow = "<?php echo $current_screen->id; ?>",
    typenow = "<?php echo $current_screen->post_type; ?>",
    thousandsSeparator = "<?php echo addslashes( $wp_locale->number_format['thousands_sep'] ); ?>",
    decimalPoint = "<?php echo addslashes( $wp_locale->number_format['decimal_point'] ); ?>",
    isRtl = <?php echo (int) is_rtl(); ?>;
  </script>
  <?php do_action( 'admin_enqueue_scripts', $hook_suffix ); ?>
  <?php do_action( "admin_print_styles-{$hook_suffix}" ); ?>
  <?php do_action( 'admin_print_styles' ); ?>
  <?php do_action( "admin_print_scripts-{$hook_suffix}" ); ?>
  <?php do_action( 'admin_print_scripts' ); ?>
  <?php do_action( "admin_head-{$hook_suffix}" ); ?>
  <?php do_action( 'admin_head' ); ?>
  <style>
    .media-modal {
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
    }
  </style>
</head>
<body>
  <?php do_action( 'admin_footer', '' ); ?>
  <?php do_action( "admin_print_footer_scripts-{$hook_suffix}" ); ?>
  <?php do_action( 'admin_print_footer_scripts' ); ?>
  <?php do_action( "admin_footer-{$hook_suffix}" ); ?>
</body>
</html>
