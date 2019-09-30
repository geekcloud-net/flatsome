<?php

namespace UxBuilder\Elements;

class Element {

  public $tag;

  public function __construct( $tag, $data ) {
    foreach ( $data as $name => $value ) {
      $this->{$name} = $value;
    }
    $this->tag = $tag;
    $this->options = new ElementOptions( $data['options'] );
  }

  /**
   * Convert element to an array ready for builder data.
   *
   * @return array
   */
  public function to_array() {
    // Convert this instance to an array. We also converts
    // all key cases to camelcase, but excludes the options.
    $vars = get_object_vars( $this );
    unset( $vars['options'] );
    $array = ux_builder_to_camelcase( $vars );
    $array['options'] = $this->options->camelcase()->to_array();

    // parse the default preset only
    $preset_content = ux_builder( 'to-array' )->transform( $array['presets'][0]['content'] );

    ux_builder_content_array_walk( $preset_content, function ( &$item ) {
      $shortcode = ux_builder_shortcodes()->get( $item['tag'] );
      $options = new ElementOptions( $shortcode['options'] );
      $item['options'] = $options->set_values( $item['options'] )->camelcase()->get_values();
    });

    $array['presets'] = array(
      array(
        'name' => $array['presets'][0]['name'],
        'content' => array_shift( $preset_content ),
      ),
    );

    return $array;
  }
}
