<?php

/**
 * Get url to a file relative to plugin directory.
 *
 * @param  string $path
 * @return string
 */
function ux_builder_url( $path = '' ) {
  return UX_BUILDER_URL . $path;
}

/**
 * Get url to a file relative to the assets directory.
 *
 * @param string $asset [description]
 * @return string
 */
function ux_builder_asset( $path ) {
  return ux_builder_url( "/assets/$path" );
}

/**
 * Renders a url for editing a post with the UX Builder.
 *
 * @param  number $post_id Post to preview.
 * @param  number $edit_post_id Post to edit.
 * @param  string $type
 * @return string
 */
function ux_builder_edit_url( $post_id, $edit_post_id = null, $type = 'editor' ) {
  $query = http_build_query( array(
    'edit_post_id' => $edit_post_id,
    'app' => 'uxbuilder',
    'type' => $type
  ) );

  return get_edit_post_link( $post_id, 'raw' ) . "&{$query}";
}

/**
 * Renders a url for the iframe.
 *
 * @return string
 */
function ux_builder_iframe_url() {
  $iframe_url = array_key_exists( 'iframe_url', $_GET ) ? $_GET['iframe_url'] : null;
  $post_id = array_key_exists( 'post', $_GET ) ? $_GET['post'] : null;
  $edit_post_id = array_key_exists( 'edit_post_id', $_GET ) ? $_GET['edit_post_id'] : null;
  $permalink = $iframe_url ? site_url( $iframe_url ) : get_permalink( $post_id );
  $has_query = !!parse_url( $permalink, PHP_URL_QUERY );
  $query_start = $has_query ? '&' : '?';

  // Fix SSL
  if(is_ssl()) $permalink = str_replace("http:", "https:", $permalink);

  if ($iframe_url) $edit_post_id = $post_id;

  return $permalink . $query_start . 'uxb_iframe&post_id=' . $post_id . ( $edit_post_id ? '&edit_post_id=' . $edit_post_id : '' );
}
