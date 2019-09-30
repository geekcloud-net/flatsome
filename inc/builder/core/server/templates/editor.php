<?php
  global $ux_builder_styles, $ux_builder_scripts;

  $editing = ux_builder( 'editing-post' );
  $title = __( 'UX Builder', 'uxbuilder' );

  if ( $editing ) $title .= ' &raquo; ' . $editing->post()->post_title;

  do_action( 'admin_enqueue_scripts' );
?><!DOCTYPE html>
<html id="ux-builder" ng-app="uxBuilder" ng-strict-di <?php language_attributes(); ?>>
<head>
  <title><?php echo $title; ?></title>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <?php wp_print_styles( $ux_builder_styles ) ?>
</head>
<body>
  <app></app>
  <app-loader></app-loader>
  <app-stack></app-stack>
  <draggable-helper></draggable-helper>
  <context-menu></context-menu>
  <flatsome-studio></flatsome-studio>

  <?php wp_print_scripts( $ux_builder_scripts ) ?>
</body>
</html>
