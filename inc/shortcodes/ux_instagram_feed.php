<?php

// Instagram Feed
function ux_instagram_feed( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'_id'                 => 'instagram-' . rand(),
		'photos'              => '10',
		'class'               => '',
		'visibility'          => '',
		'username'            => 'wonderful_places',
		'hashtag'             => '',
		'hashtag_media'       => 'top', // or recent
		'target'              => '_self',
		'caption'             => 'true',
		'link'                => '',
		// Layout.
		'columns'             => '5',
		'columns__sm'         => '',
		'columns__md'         => '',
		'type'                => 'row',
		'col_spacing'         => 'collapse',
		'slider_style'        => '',
		'slider_nav_color'    => '',
		'slider_nav_style'    => '',
		'slider_nav_position' => '',
		'slider_bullets'      => 'false',
		'width'               => '',
		'depth'               => '',
		'depth_hover'         => '',
		'animate'             => '',
		'auto_slide'          => '',
		// Image.
		'lightbox'            => '',
		'image_overlay'       => '',
		'image_hover'         => 'overlay-remove',
		'size'                => 'small', // small - thumbnail - original.
	), $atts ) );

	ob_start();

	$limit = $photos;

	if ( $username != '' ) {
		if ( substr( $username, 0, 1 ) === '#' ) {
			$hashtag = substr( $username, 1 );
		}

		$media_array = flatsome_instagram_get_feed( $username, $hashtag, $hashtag_media );

		if ( is_wp_error( $media_array ) ) {

			echo wp_kses_post( $media_array->get_error_message() );

		} else {

			// Slice list down to required limit.
			$media_array = array_slice( $media_array, 0, $limit );

			$repeater['id']                  = $_id;
			$repeater['type']                = $type;
			$repeater['class']               = $class;
			$repeater['visibility']          = $visibility;
			$repeater['style']               = 'overlay';
			$repeater['slider_style']        = $slider_nav_style;
			$repeater['slider_nav_position'] = $slider_nav_position;
			$repeater['slider_nav_color']    = $slider_nav_color;
			$repeater['slider_bullets']      = $slider_bullets;
			$repeater['auto_slide']          = $auto_slide;
			$repeater['row_spacing']         = $col_spacing;
			$repeater['row_width']           = $width;
			$repeater['columns']             = $columns;
			$repeater['columns__sm']         = $columns__sm;
			$repeater['columns__md']         = $columns__md;
			$repeater['depth']               = $depth;
			$repeater['depth_hover']         = $depth_hover;

			// Filters for custom classes.
			get_flatsome_repeater_start( $repeater );

			foreach ( $media_array as $item ) {
				echo '<div class="col"><div class="col-inner">';

				$image_url = $item[ $size ];

				if ( $item['type'] === 'video' && empty( $item['thumbnail_url'] ) ) {
					$image_url = $item['link'] . 'media?size=l';
				}

				if ( $caption ) {
					$caption = $item['description'];
				}
				?>
				<div class="img has-hover no-overflow">
					<div class="dark instagram-image-container image-<?php echo $image_hover; ?> instagram-image-type--<?php echo $item['type']; ?>">
						<a href="<?php echo $item['link']; ?>" target="_blank" rel="noopener noreferrer" class="plain">
							<?php echo flatsome_get_image( $image_url, false, $caption ); ?>
							<?php if ( $image_overlay ) { ?>
								<div class="overlay" style="background-color: <?php echo $image_overlay; ?>"></div>
							<?php } ?>
							<?php if ( $caption ) { ?>
								<div class="caption"><?php echo $caption; ?></div>
							<?php } ?>
						</a>
					</div>
				</div>
				<?php
				echo '</div></div>';
			}

			get_flatsome_repeater_end( $repeater );
		}
	}

	if ( $link != '' ) {
		?>
		<a class="plain uppercase" href="<?php echo trailingslashit( '//instagram.com/' . esc_attr( trim( $username ) ) ); ?>" rel="me"
			 target="<?php echo esc_attr( $target ); ?>"><?php echo get_flatsome_icon( 'icon-instagram' ); ?><?php echo wp_kses_post( $link ); ?></a>
		<?php
	}

	$w = ob_get_contents();

	ob_end_clean();

	return $w;

}

add_shortcode( 'ux_instagram_feed', 'ux_instagram_feed' );

function flatsome_instagram_get_feed( $username, $hashtag, $hashtag_media ) {
	$accounts         = flatsome_facebook_accounts();
	$username         = strtolower( $username );
	$username         = str_replace( '@', '', $username );
	$account          = array_key_exists( $username, $accounts ) ? $accounts[ $username ] : false;

	$transient_suffix = ($hashtag ? 'h' : 'u') . ($account ? 't' : '') . $hashtag_media;
	$transient_name   = 'instagram-a1-' . $transient_suffix . '-' . sanitize_title_with_dashes( $username . $hashtag );
	$instagram        = get_transient( $transient_name );

	if ( ! empty( $instagram ) ) {
		return unserialize( base64_decode( $instagram ) );
	}

	if ( $account ) {
		$instagram = flatsome_instagram_account_feed( $username, $account, $hashtag, $hashtag_media );
	} else {
		$instagram = flatsome_instagram_scrape_html( $username, $hashtag );
	}

	if ( is_wp_error( $instagram ) ) {
		return $instagram;
	} else if ( empty( $instagram ) ) {
		return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'flatsome-admin' ) );
	}

	// Do not set an empty transient, helps catching private or empty accounts.
	$instagram_cache = base64_encode( serialize( $instagram ) ); //100% safe - ignore theme check nag
	set_transient( $transient_name, $instagram_cache, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );

	return $instagram;
}

function flatsome_instagram_account_feed( $username, $account, $hashtag = '', $hashtag_media = 'top' ) {
	$id           = $account['id'];
	$access_token = $account['access_token'];
	$results      = array();
	$instagram    = array();

	if ( $hashtag ) {
		$results = flatsome_instagram_get_hashtag_media( $hashtag, $hashtag_media, $id, $access_token );
	} else {
		$results = flatsome_instagram_get_media( $id, $access_token );
	}

	if ( is_wp_error( $results ) ) {
		return $results;
	} else if ( ! $results || empty( $results['data'] ) ) {
		return $instagram;
	}

	foreach ( $results['data'] as $item ) {
		$caption = ! empty( $item['caption'] )
			? wp_kses( $item['caption'], array() )
			: __( 'Instagram Image', 'flatsome-admin' );

		$timestamp = array_key_exists( 'timestamp', $item )
			? $item['timestamp']
			: null;

		$media_url = array_key_exists( 'media_url', $item )
			? set_url_scheme( $item['media_url'] )
			: null;

		$instagram[] = array(
			'description' => $caption,
			'link'        => $item['permalink'],
			'time'        => $timestamp,
			'comments'    => $item['comments_count'],
			'likes'       => $item['like_count'],
			'thumbnail'   => $media_url,
			'small'       => $media_url,
			'large'       => $media_url,
			'original'    => $media_url,
			'type'        => strtolower( $item['media_type'] )
		);
	}

	return $instagram;
}

function flatsome_instagram_get_media( $id, $access_token ) {
	$fields    = 'timestamp,caption,media_type,media_url,thumbnail_url,like_count,comments_count,permalink';
	$url       = "https://graph.facebook.com/v4.0/$id/media?fields=$fields&access_token=$access_token";
	$response  = wp_remote_get( $url );

	if ( is_wp_error( $response ) ) {
		return new WP_Error( 'site_down', __( 'Unable to communicate with Instagram.', 'flatsome-admin' ) );
	} else {
		$body = json_decode( $response['body'], true );

		if ( array_key_exists( 'error', $body ) ) {
			return new WP_Error( 'site_down', $body['error']['message'] );
		}

		return $body;
	}
}

function flatsome_instagram_get_hashtag_id( $hashtag, $user_id, $access_token ) {
	if ( substr( $hashtag, 0, 1 ) === '#' ) {
		$hashtag = substr( $hashtag, 1 );
	}

	$url = "https://graph.facebook.com/v4.0/ig_hashtag_search?user_id=$user_id&q=$hashtag&access_token=$access_token";
	$response = wp_remote_get( $url );

	if ( is_wp_error( $response ) ) {
		return new WP_Error( 'site_down', __( 'Unable to communicate with Instagram.', 'flatsome-admin' ) );
	} else {
		$body = json_decode( $response['body'], true );

		if ( array_key_exists( 'error', $body ) ) {
			return new WP_Error( 'site_down', $body['error']['message'] );
		}

		return $body ;
	}
}

function flatsome_instagram_get_hashtag_media( $name, $type, $user_id, $access_token ) {
	$hashtag = flatsome_instagram_get_hashtag_id( $name, $user_id, $access_token );

	if ( is_wp_error( $hashtag ) ) {
		return $hashtag;
	}

	$tag_id = $hashtag['data'][ 0 ]['id'];
	$endpoint = $type === 'recent' ? 'recent_media' : 'top_media';
	$fields = 'caption,media_type,media_url,like_count,comments_count,permalink';
	$url = "https://graph.facebook.com/v4.0/$tag_id/$endpoint?user_id=$user_id&fields=$fields&access_token=$access_token";
	$response = wp_remote_get( $url );

	if ( is_wp_error( $response ) ) {
		return new WP_Error( 'site_down', __( 'Unable to communicate with Instagram.', 'flatsome-admin' ) );
	} else {
		$body = json_decode( $response['body'], true );

		if ( array_key_exists( 'error', $body ) ) {
			return new WP_Error( 'site_down', $body['error']['message'] );
		}

		return $body;
	}
}

function flatsome_instagram_scrape_html( $username, $hashtag ) {
	$req_param = ( $hashtag ) ? 'explore/tags/' . $hashtag : trim( $username );
	$remote    = wp_remote_get( 'https://instagram.com/' . $req_param );
	$instagram = array();

	if ( is_wp_error( $remote ) ) {
		return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'flatsome-admin' ) );
	}

	if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
		return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'flatsome-admin' ) );
	}

	$shards      = explode( 'window._sharedData = ', $remote['body'] );
	$insta_json  = explode( ';</script>', $shards[1] );
	$insta_array = json_decode( $insta_json[0], true );

	if ( ! $insta_array ) {
		return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'flatsome-admin' ) );
	}

	if ( isset( $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
		$edges = $insta_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
	} elseif ( $hashtag && isset( $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
		$edges = $insta_array['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
	} else {
		return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'flatsome-admin' ) );
	}

	if ( ! is_array( $edges ) ) {
		return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'flatsome-admin' ) );
	}

	foreach ( $edges as $edge ) {
		$edge['node']['thumbnail_src'] = preg_replace( '/^https?\:/i', '', $edge['node']['thumbnail_src'] );
		$edge['node']['display_url']   = preg_replace( '/^https?\:/i', '', $edge['node']['display_url'] );

		if ( isset( $edge['node']['thumbnail_resources'] ) && is_array( $edge['node']['thumbnail_resources'] ) ) {
			$edge['node']['thumbnail'] = set_url_scheme( $edge['node']['thumbnail_resources'][0]['src'] ); // 150x150
			$edge['node']['small']     = set_url_scheme( $edge['node']['thumbnail_resources'][2]['src'] ); // 320x320
		} else {
			$edge['node']['thumbnail'] = $edge['node']['small'] = $edge['node']['thumbnail_src'];
		}

		$edge['node']['large'] = $edge['node']['thumbnail_src'];

		if ( $edge['node']['is_video'] == true ) {
			$type = 'video';
		} else {
			$type = 'image';
		}

		$caption = __( 'Instagram Image', 'flatsome-admin' );
		if ( ! empty( $edge['node']['edge_media_to_caption']['edges'][0]['node']['text'] ) ) {
			$caption = wp_kses( $edge['node']['edge_media_to_caption']['edges'][0]['node']['text'], array() );
		}

		$instagram[] = array(
			'description' => $caption,
			'link'        => trailingslashit( '//instagram.com/p/' . $edge['node']['shortcode'] ),
			'time'        => $edge['node']['taken_at_timestamp'],
			'comments'    => $edge['node']['edge_media_to_comment']['count'],
			'likes'       => $edge['node']['edge_liked_by']['count'],
			'thumbnail'   => $edge['node']['thumbnail'],
			'small'       => $edge['node']['small'],
			'large'       => $edge['node']['large'],
			'original'    => $edge['node']['display_url'],
			'type'        => $type,
		);
	}

	return $instagram;
}
