<?php

namespace UxBuilder\Ajax;

use UxBuilder\Post\PostArray;
use UxBuilder\Elements\ElementOptions;

class AjaxManager {

  protected $data;
  protected $do_shortcode;
  protected $posts;
  protected $post_saver;
  protected $wp_attachment;
  protected $terms;

  public function __construct() {
    $this->data = new Data();
    $this->do_shortcode = new DoShortcode();
    $this->posts = new Posts();
    $this->post_saver = new PostSaver();
    $this->wp_attachment = new WpAttachment();
    $this->terms = new Terms();

    add_action( 'wp_ajax_ux_builder_get_data', array( $this->data, 'get_data' ) );
    add_action( 'wp_ajax_ux_builder_search_posts', array( $this->posts, 'search_posts' ) );
    add_action( 'wp_ajax_ux_builder_get_posts', array( $this->posts, 'get_posts' ) );
    add_action( 'wp_ajax_ux_builder_save', array( $this->post_saver, 'save' ) );
    add_action( 'wp_ajax_ux_builder_get_attachment', array( $this->wp_attachment, 'get_attachment' ) );
    add_action( 'wp_ajax_ux_builder_search_terms', array( $this->terms, 'search_terms' ) );
    add_action( 'wp_ajax_ux_builder_get_terms', array( $this->terms, 'get_terms' ) );
    add_action( 'wp_ajax_ux_builder_to_array', array( $this, 'to_array' ) );
    add_action( 'wp_ajax_ux_builder_parse_presets', array( $this, 'parse_presets' ) );
    add_action( 'wp_ajax_ux_builder_import_media', array( $this, 'import_media' ) );

    if ( ! array_key_exists( 'ux_builder_action', $_POST ) ) return;

    add_action( 'template_redirect', array( $this->do_shortcode, 'do_shortcode' ), 0 );
  }

  /**
   * Converts content or a template to an array.
   * Used by the import function and template selector.
   */
  public function to_array () {
    $content = '';

    if ( array_key_exists( 'content', $_POST ) ) {
      $content = stripslashes( $_POST['content'] );
    } else if ( array_key_exists( 'id', $_POST ) ) {
      $id = $_POST['id'];
      $template = ux_builder_get_template( $id );
      $content = $template['content'];
    }

    $post_array = new PostArray( (object) array(
      'post_content' => $content
    ) );

    return wp_send_json_success( array(
      'content' => $post_array->get_array()
    ) );
  }

  /**
   * Importa external meda files.
   */
  public function import_media () {
    $id = $_POST['id'];
    $url = $_POST['url'];

    // 1. Check if image is already imported by its ID.
    $query = new \WP_Query( array(
      'post_type' => 'attachment',
      'post_status' => 'inherit',
      'meta_query' => array(
        array( 'key' => '_flatsome_studio_id', 'value' => $id, 'compare' => '=' )
      )
    ) );

    if ( $query->have_posts() ) {
      return wp_send_json_success( array(
        'id' => $query->posts[0]->ID,
      ) );
    }

    // 2. Download image from URL.
    $file = array();
    $file['name'] = basename( $url );
    $file['tmp_name'] = download_url( $url );

    if ( is_wp_error( $file['tmp_name'] ) ) {
      @unlink( $file['tmp_name'] );
      return new \WP_Error( 'flatsome', 'Could not download image from Flatsome Studio.' );
    }

    // 3. Add image to media library.
    $attachment_id = media_handle_sideload( $file, 0 );
    $attach_data = wp_generate_attachment_metadata( $attachment_id,  get_attached_file( $attachment_id ) );
    wp_update_attachment_metadata( $attachment_id,  $attach_data );
    update_post_meta( $attachment_id, '_flatsome_studio_id', $id );

    // 4. Return local ID and URL.
    return wp_send_json_success( array(
      'id' => $attachment_id,
    ) );
  }

  /**
   * Parse presets for a shortcode.
   */
  public function parse_presets () {
    $shortcode = ux_builder_shortcodes()->get( $_GET['tag'] );

    if ( ! $shortcode ) {
      return wp_send_json_success( array(
        'presets' => array(),
      ) );
    }

    $presets = array_map( function ( $preset ) {
      $array = ux_builder( 'to-array' )->transform( $preset['content'] );

      ux_builder_content_array_walk( $array, function ( &$item ) {
        $shortcode = ux_builder_shortcodes()->get( $item['tag'] );
        $options = new ElementOptions( $shortcode['options'] );
        $item['options'] = $options->set_values( $item['options'] )->camelcase()->get_values();
      });

      $preset['content'] = array_shift( $array );

      return $preset;
    }, $shortcode['presets'] );

    return wp_send_json_success( array(
      'presets' => $presets,
    ) );
  }
}
