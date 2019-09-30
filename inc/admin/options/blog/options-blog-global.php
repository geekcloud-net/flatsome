<?php

Flatsome_Option::add_section( 'blog-global', array(
	'title' => __( 'Blog Global', 'flatsome-admin' ),
	'panel' => 'blog',
) );

Flatsome_Option::add_field( 'option', array(
	'type'        => 'text',
	'settings'    => 'blog_excerpt_suffix',
	'label'       => __( 'Blog Excerpt Suffix', 'flatsome-admin' ),
	'description' => __( 'Choose custom post excerpt suffix. Default [...]', 'flatsome-admin' ),
	'section'     => 'blog-global',
	'default'     => ' [...]',
) );
