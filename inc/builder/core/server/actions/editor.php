<?php

$priority = 1000;

add_action( 'init', function () {
  remove_action( 'init', 'ckeditor_init' ); // ckeditor is not supported
}, -$priority );

/**
* Render editor template.
*
* @param string $page_template
*/
add_action( 'current_screen', function ( $screen ) {
  if ( $screen->base !== 'post' ) return; // not a post page
  if ( ! array_key_exists( 'app', $_GET ) ) return;
  if ( ! array_key_exists( 'type', $_GET ) ) return;

  $post_types = get_ux_builder_post_types();
  $post = ux_builder( 'editing-post' )->post();

  // Render template for registered post types only.
  if ( array_key_exists( $post->post_type, $post_types ) ) {

    if ( $_GET['type'] === 'editor' ) {
      ux_builder_enqueue_editor_assets();
    }

    ux_builder_render( $_GET['type'] );

    die;
  }

  wp_die( "The <em>$post->post_type</em> post type is not available for UX Builder." );
} );

/**
 * Modify the language attributes. Force ltr text direction.
 */
add_filter( 'language_attributes', function ( $output, $doctype ) {
  return str_replace( 'dir="rtl"', 'dir="ltr"', $output );
}, $priority, 2 );

function ux_builder_enqueue_editor_assets() {
  global $wp_styles, $wp_scripts, $ux_builder_styles, $ux_builder_scripts;

  $data = ux_builder_editor_data();
  $version = UX_BUILDER_VERSION;

  wp_enqueue_style(
    'ux-builder-core',
    ux_builder_asset( 'css/builder/core/editor.css' ),
    array( 'dashicons', 'forms', 'buttons' ),
    $version
  );

  wp_enqueue_script(
    'ux-builder-vendors',
    ux_builder_asset( 'js/builder/core/vendors.js' ),
    array( 'jquery', 'underscore', 'jquery-ui-sortable' ),
    $version,
    true
  );

  wp_enqueue_script(
    'ux-builder-core',
    ux_builder_asset( 'js/builder/core/editor.js' ),
    array( 'ux-builder-vendors' ),
    $version,
    true
  );

  do_action( 'ux_builder_enqueue_scripts', 'editor' );

  $ux_builder_styles  = array_merge(
    array( 'ux-builder-core' ),
    ux_builder_deps( $wp_styles, 'ux-builder-core' )
  );

  $ux_builder_scripts = array_merge(
    array( 'ux-builder-core' ),
    ux_builder_deps( $wp_scripts, 'ux-builder-core' )
  );

  $script = 'var uxBuilderData = ' . wp_json_encode( $data ) . ';';
  wp_add_inline_script( 'ux-builder-core', $script, 'before' );
}

/**
 * Removes unwanted actions and assets in
 * the «admin_print_footer_scripts» action.
 * Then prints all builder data.
 */
function ux_builder_editor_data() {
  $current_post = ux_builder( 'current-post' );
  $editing_post = ux_builder( 'editing-post' );
  $post_id = $editing_post->post()->ID;
  $post_status = $editing_post->post()->post_status;
  $can_edit = current_user_can( 'edit_post', $post_id );
  $can_publish = current_user_can( 'publish_post', $post_id );
  $has_flatsome_studio = get_theme_mod( 'flatsome_studio', 1 );

  // Get the back URL. Redirect to admin page if user came
  // from admin or to the post if user came from some other place.
  $back_url = isset( $_SERVER['HTTP_REFERER'] )
    ? $_SERVER['HTTP_REFERER']
    : $current_post->permalink();

  // Go back to admin edit screen if not published.
  if ( $editing_post->post()->post_status != 'publish' &&
    strpos( $back_url, 'preview=true' ) == false) {
    $back_url = admin_url( 'post.php?post=' . $editing_post->post()->ID . '&action=edit' );
  }

  if ( $can_publish ) {
    $save_button = $post_status != 'publish'
      ? __( 'Publish', 'wordpress' )
      : __( 'Update', 'wordpress' );
  } else {
    $save_button = $post_status == 'pending'
      ? __( 'Submit for Review', 'wordpress' )
      : __( 'Save draft', 'wordpress' );
  }

  $data = apply_filters( 'ux_builder_data', array(
    'loading' => true,
    'initialized' => false,
    'nonce' => wp_create_nonce( 'ux-builder-' . $editing_post->post()->ID ),
    'ajaxUrl' => admin_url( 'admin-ajax.php' ),
    'flatsomeStudioUrl' => $has_flatsome_studio
      ? ( is_ssl() ? 'https' : 'http' ) . '://demos.uxthemes.com/'
      : null,
    'iframeUrl' => ux_builder_iframe_url(),
    'backUrl' => $back_url,
    'editUrl' => $current_post->editlink(),
    'postUrl' => $current_post->permalink(),
    'wpMediaUrl' => ux_builder_edit_url( $post_id, null, 'media' ),
    'wpEditorUrl' => ux_builder_edit_url( $post_id, null, 'tinymce' ),
    'post' => $editing_post->to_array(),
    'saveButton' => $save_button,
    'showSidebar' => true,
    'showFlatsomeStudio' => false,
    'breakpoints' => array(
      'current' => get_default_ux_builder_breakpoint(),
      'default' => get_default_ux_builder_breakpoint(),
      'all' => get_ux_builder_breakpoints(),
    ),
    'permissions' => array(
      'exit' => true,
      'edit' => true,
      'save' => true,
      'upload' => true,
    ),
    'clipboard' => array(
      'options' => (object) array(),
      'shortcode' => (object) array(),
    ),
    'shortcodes' => ux_builder( 'elements' )->to_array(),
    'modules' => apply_filters( 'ux_builder_modules', array() ),
    'shortcode' => (object) array(),
    'states' => (object) array(),
    'tools' => (object) array(),
    'cache' => (object) array(),
    'actions' => array(),
    'targets' => array(),
    '$$events' => (object) array(),
    '$$filters' => (object) array(),
    '$$actions' => (object) array(),
  ) );

  // Get templates for current post type.
  $data['templates'] = array_filter( ux_builder( 'templates' )->to_array(), function ( $template ) {
    return in_array( ux_builder( 'editing-post' )->post()->post_type, $template['post_types'] );
  } );

  return $data;
}

/**
* Add buttons to TinyMCE editor.
*/
add_action( 'media_buttons', function () {
  echo '<button type="button" onclick="uxBuilderHide()" class="button button-primary"><span class="dashicons dashicons-yes"></span>OK</button>';
  echo '<button type="button" onclick="uxBuilderDiscard()" class="button"><span class="dashicons dashicons-no-alt"></span>Cancel</button>';
  echo '<span class="separator"></span>';
}, 0 );
