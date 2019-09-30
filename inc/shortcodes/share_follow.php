<?php
// [share]
function flatsome_share($atts, $content = null) {
	extract(shortcode_atts(array(
		'title'  => '',
		'class'	=> '',
		'visibility' => '',
		'size' => '',
		'align' => '',
		'scale' => '',
		'style' => '',
	), $atts));

	// Get Custom Share icons if set
	if(get_theme_mod('custom_share_icons')){
		return do_shortcode(get_theme_mod('custom_share_icons'));
	}

	$wrapper_class = array('social-icons','share-icons', 'share-row', 'relative');
	if( $class ) $wrapper_class[] = $class;
	if( $visibility ) $wrapper_class[] = $visibility;
	if( $align ) {
		$wrapper_class[] = 'full-width';
		$wrapper_class[] = 'text-'.$align;
	}
	if ( $style ) $wrapper_class[] = 'icon-style-'.$style;


	global $post;
	if(!$post) return false;

	$post_id   = $post->ID;
	$permalink = get_permalink( $post_id );

	if ( is_woocommerce_activated() && is_shop() ) {
		$post_id   = wc_get_page_id( 'shop' );
		$permalink = get_permalink( $post_id );
	}

	$featured_image =  wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'large');
	$featured_image_2 = $featured_image['0'];
	$post_title = rawurlencode(get_the_title($post_id));
	$whatsapp_text = $post_title.' - '.$permalink;

	if($title) $title = '<span class="share-icons-title">'.$title.'</span>';

	// Style default

	// Get Custom Theme Style
	if(!$style) $style = get_theme_mod('social_icons_style','outline');

	$classes = get_flatsome_icon_class($style);
	$classes = $classes. ' tooltip';

	$share = get_theme_mod('social_icons', array('facebook','twitter','email','linkedin','pinterest','whatsapp'));

	// Scale
	if($scale) $scale = 'style="font-size:'.$scale.'%"';


	// Fix old depricated
	if(!isset($share[0])){
		$fix_share = array();
		foreach ($share as $key => $value) {
			if($value == '1') $fix_share[] = $key;
		}
		$share = $fix_share;
	}

	ob_start();

	?>

	<div class="<?php echo implode(' ', $wrapper_class); ?>" <?php echo $scale;?>>
		  <?php echo $title; ?>
		  <?php if(in_array('whatsapp', $share)){ ?>
		  <a href="whatsapp://send?text=<?php echo $whatsapp_text; ?>" data-action="share/whatsapp/share" class="<?php echo $classes;?> whatsapp show-for-medium" title="<?php _e('Share on WhatsApp','flatsome'); ?>"><i class="icon-phone"></i></a>
		  <?php } if(in_array('facebook', $share)){ ?>
		  <a href="//www.facebook.com/sharer.php?u=<?php echo $permalink; ?>" data-label="Facebook" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;" rel="noopener noreferrer nofollow" target="_blank" class="<?php echo $classes;?> facebook" title="<?php _e('Share on Facebook','flatsome'); ?>"><?php echo get_flatsome_icon('icon-facebook'); ?></a>
		  <?php } if(in_array('twitter', $share)){ ?>
          <a href="//twitter.com/share?url=<?php echo $permalink; ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;" rel="noopener noreferrer nofollow" target="_blank" class="<?php echo $classes;?> twitter" title="<?php _e('Share on Twitter','flatsome'); ?>"><?php echo get_flatsome_icon('icon-twitter'); ?></a>
          <?php } if(in_array('email', $share)){ ?>
          <a href="mailto:enteryour@addresshere.com?subject=<?php echo $post_title; ?>&amp;body=Check%20this%20out:%20<?php echo $permalink; ?>" rel="nofollow" class="<?php echo $classes;?> email" title="<?php _e('Email to a Friend','flatsome'); ?>"><?php echo get_flatsome_icon('icon-envelop'); ?></a>
          <?php } if(in_array('pinterest', $share)){ ?>
          <a href="//pinterest.com/pin/create/button/?url=<?php echo $permalink; ?>&amp;media=<?php echo $featured_image_2; ?>&amp;description=<?php echo $post_title; ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;" rel="noopener noreferrer nofollow" target="_blank" class="<?php echo $classes;?> pinterest" title="<?php _e('Pin on Pinterest','flatsome'); ?>"><?php echo get_flatsome_icon('icon-pinterest'); ?></a>
          <?php } if(in_array('vk', $share)){ ?>
          <a href="//vkontakte.ru/share.php?url=<?php echo $permalink; ?>" target="_blank" class="<?php echo $classes;?> vk" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;" rel="noopener noreferrer nofollow" title="<?php _e('Share on VKontakte','flatsome'); ?>"><?php echo get_flatsome_icon('icon-vk'); ?></a>
          <?php } if(in_array('linkedin', $share)){ ?>
          <a href="//www.linkedin.com/shareArticle?mini=true&url=<?php echo $permalink; ?>&title=<?php echo $post_title; ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;"  rel="noopener noreferrer nofollow" target="_blank" class="<?php echo $classes;?> linkedin" title="<?php _e('Share on LinkedIn','flatsome'); ?>"><?php echo get_flatsome_icon('icon-linkedin'); ?></a>
          <?php } if(in_array('tumblr', $share)){ ?>
          <a href="//tumblr.com/widgets/share/tool?canonicalUrl=<?php echo $permalink; ?>" target="_blank" class="<?php echo $classes;?> tumblr" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;"  rel="noopener noreferrer nofollow" title="<?php _e('Share on Tumblr','flatsome'); ?>"><?php echo get_flatsome_icon('icon-tumblr'); ?></a>
          <?php } ?>
    </div>

    <?php
	$content = ob_get_contents();
	ob_end_clean();
	$content = flatsome_sanitize_whitespace_chars( $content);
	return $content;
}
add_shortcode('share','flatsome_share');


// [follow]
function flatsome_follow($atts, $content = null) {
	$sliderrandomid = rand();
	extract(shortcode_atts(array(
		'title' => '',
		'class' => '',
		'visibility' => '',
		'style' => 'outline',
		'align' => '',
		'scale' => '',
		'defaults' => '',
		'twitter' => '',
		'facebook' => '',
		'pinterest' => '',
		'email' => '',
		'phone' => '',
		'instagram' => '',
		'rss' => '',
		'linkedin' => '',
		'youtube' => '',
		'flickr' => '',
		'vkontakte' => '',
		'px500' => '',
		'snapchat' => '',

		// Depricated
		'size' => '',

	), $atts));
	ob_start();


	$wrapper_class = array('social-icons','follow-icons');
	if( $class ) $wrapper_class[] = $class;
	if( $visibility ) $wrapper_class[] = $visibility;
	if( $align ) {
		$wrapper_class[] = 'full-width';
		$wrapper_class[] = 'text-'.$align;
	}


	// Get Defaults
	if($defaults){
		$twitter = get_theme_mod('follow_twitter');
		$facebook = get_theme_mod('follow_facebook');
		$instagram = get_theme_mod('follow_instagram');
		$snapchat = get_theme_mod('follow_snapchat');
		$youtube = get_theme_mod('follow_youtube');
		$pinterest = get_theme_mod('follow_pinterest');
		$linkedin = get_theme_mod('follow_linkedin');
		$px500 = get_theme_mod('follow_500px');
		$vkontakte = get_theme_mod('follow_vk');
		$flickr = get_theme_mod('follow_flickr');
		$email = get_theme_mod('follow_email');
		$phone = get_theme_mod('follow_phone');
		$rss = get_theme_mod('follow_rss');
	}

	if($size == 'small') $style = 'small';
	$style = get_flatsome_icon_class($style);

	// Scale
	if($scale) $scale = 'style="font-size:'.$scale.'%"';
	

	?>
    <div class="<?php echo implode(' ', $wrapper_class); ?>" <?php echo $scale;?>>
    	<?php if($title){?>
    	<span><?php echo $title; ?></span>
		<?php }?>
    	<?php if($facebook){?>
    	<a href="<?php echo $facebook; ?>" target="_blank" data-label="Facebook"  rel="noopener noreferrer nofollow" class="<?php echo $style; ?> facebook tooltip" title="<?php _e('Follow on Facebook','flatsome') ?>"><?php echo get_flatsome_icon('icon-facebook'); ?>
    	</a>
		<?php }?>
		<?php if($instagram){?>
		    <a href="<?php echo $instagram; ?>" target="_blank" rel="noopener noreferrer nofollow" data-label="Instagram" class="<?php echo $style; ?>  instagram tooltip" title="<?php _e('Follow on Instagram','flatsome')?>"><?php echo get_flatsome_icon('icon-instagram'); ?>
		   </a>
		<?php }?>
		<?php if($snapchat){?>
		    <a href="#" data-open="#follow-snapchat-lightbox" data-color="dark" data-pos="center" target="_blank" rel="noopener noreferrer nofollow" data-label="SnapChat" class="<?php echo $style; ?> snapchat tooltip" title="<?php _e('Follow on SnapChat','flatsome')?>"><?php echo get_flatsome_icon('icon-snapchat'); ?>
		   </a>
		   <div id="follow-snapchat-lightbox" class="mfp-hide">
		   		<div class="text-center">
			   		<?php echo do_shortcode(flatsome_get_image($snapchat)) ;?>
			   		<p><?php _e('Point the SnapChat camera at this to add us to SnapChat.','flatsome'); ?></p>
		   		</div>
		   </div>
		<?php }?>
		<?php if($twitter){?>
	       <a href="<?php echo $twitter; ?>" target="_blank"  data-label="Twitter"  rel="noopener noreferrer nofollow" class="<?php echo $style; ?>  twitter tooltip" title="<?php _e('Follow on Twitter','flatsome') ?>"><?php echo get_flatsome_icon('icon-twitter'); ?>
	       </a>
		<?php }?>
		<?php if($email){?>
		     <a href="mailto:<?php echo $email; ?>" data-label="E-mail"  rel="nofollow" class="<?php echo $style; ?>  email tooltip" title="<?php _e('Send us an email','flatsome') ?>"><?php echo get_flatsome_icon('icon-envelop'); ?>
			</a>
		<?php }?>
	    <?php if($phone){?>
			<a href="tel:<?php echo $phone; ?>" target="_blank"  data-label="Phone"  rel="noopener noreferrer nofollow" class="<?php echo $style; ?>  phone tooltip" title="<?php _e('Call us','flatsome') ?>"><?php echo get_flatsome_icon('icon-phone'); ?>
			</a>
	    <?php }?>
		<?php if($pinterest){?>
		       <a href="<?php echo $pinterest; ?>" target="_blank" rel="noopener noreferrer nofollow"  data-label="Pinterest"  class="<?php echo $style; ?>  pinterest tooltip" title="<?php _e('Follow on Pinterest','flatsome') ?>"><?php echo get_flatsome_icon('icon-pinterest'); ?>
		       </a>
		<?php }?>
		<?php if($rss){?>
		       <a href="<?php echo $rss; ?>" target="_blank" rel="noopener noreferrer nofollow" data-label="RSS Feed" class="<?php echo $style; ?>  rss tooltip" title="<?php _e('Subscribe to RSS','flatsome') ?>"><?php echo get_flatsome_icon('icon-feed'); ?></a>
		<?php }?>
		<?php if($linkedin){?>
		       <a href="<?php echo $linkedin; ?>" target="_blank" rel="noopener noreferrer nofollow" data-label="LinkedIn" class="<?php echo $style; ?>  linkedin tooltip" title="<?php _e('Follow on LinkedIn','flatsome') ?>"><?php echo get_flatsome_icon('icon-linkedin'); ?></a>
		<?php }?>
		<?php if($youtube){?>
		       <a href="<?php echo $youtube; ?>" target="_blank" rel="noopener noreferrer nofollow" data-label="YouTube" class="<?php echo $style; ?>  youtube tooltip" title="<?php _e('Follow on YouTube','flatsome') ?>"><?php echo get_flatsome_icon('icon-youtube'); ?>
		       </a>
		<?php }?>
		<?php if($flickr){?>
		       <a href="<?php echo $flickr; ?>" target="_blank" rel="noopener noreferrer nofollow" data-label="Flickr" class="<?php echo $style; ?>  flickr tooltip" title="<?php _e('Flickr','flatsome') ?>"><?php echo get_flatsome_icon('icon-flickr'); ?>
		       </a>
		<?php }?>
		<?php if($px500){?>
		     <a href="<?php echo $px500; ?>" target="_blank"  data-label="500px"  rel="noopener noreferrer nofollow" class="<?php echo $style; ?> px500 tooltip" title="<?php _e('Follow on 500px','flatsome') ?>"><?php echo get_flatsome_icon('icon-500px'); ?>
			</a>
		<?php }?>
		<?php if($vkontakte){?>
		       <a href="<?php echo $vkontakte; ?>" target="_blank" data-label="VKontakte" rel="noopener noreferrer nofollow" class="<?php echo $style; ?> vk tooltip" title="<?php _e('Follow on VKontakte','flatsome') ?>"><?php echo get_flatsome_icon('icon-vk'); ?>
		       </a>
		<?php }?>
     </div>

	<?php
	$content = ob_get_contents();
	ob_end_clean();
	$content = flatsome_sanitize_whitespace_chars( $content);
	return $content;
}
add_shortcode("follow", "flatsome_follow");
