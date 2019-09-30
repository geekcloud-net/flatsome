<?php

return array(
	'type'      => 'group',
	'heading'   => __( 'Video', 'ux-builder' ),
	'collapsed' => true,
	'options'   => array(
		'youtube'          => array(
			'type'        => 'textfield',
			'heading'     => 'YouTube',
			'description' => 'Add a youtube ID here. F.ex 9d8wWcJLnFI',
		),
		'video_mp4'        => array(
			'type'        => 'textfield',
			'heading'     => 'Video MP4',
			'description' => 'Nice tool to convert videos: https://cloudconvert.org/',
		),
		'video_ogg'        => array(
			'type'    => 'textfield',
			'heading' => 'Video OGG ',

		),
		'video_webm'       => array(
			'type'    => 'textfield',
			'heading' => 'Video WEBM',
		),
		'video_sound'      => array(
			'type'    => 'select',
			'heading' => 'Sound',
			'default' => 'false',
			'options' => array(
				'true'  => 'Enable',
				'false' => 'Disable',
			),
		),
		'video_loop'       => array(
			'type'    => 'select',
			'heading' => 'Loop',
			'default' => 'true',
			'options' => array(
				'true'  => 'Loop',
				'false' => 'No loop',
			),
		),
		'video_visibility' => array(
			'type'    => 'select',
			'heading' => 'Visibility',
			'default' => 'hide-for-medium',
			'options' => array(
				'visible'                        => 'Visible',
				'hidden'                         => 'Hidden',
				'hide-for-medium'                => 'Only for Desktop',
				'show-for-small'                 => 'Only for Mobile',
				'show-for-medium hide-for-small' => 'Only for Tablet',
				'show-for-medium'                => 'Hide for Desktop',
				'hide-for-small'                 => 'Hide for Mobile',
			),
		),
	),
);
