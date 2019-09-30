<?php

// Exit if class does not exist.
if ( ! class_exists( 'YITH_WCWL' ) ) {
	return;
}

$icon_style = get_theme_mod( 'wishlist_icon_style' );

?>
<li class="header-wishlist-icon has-icon">
	<?php if($icon_style) { ?><div class="header-button"><?php } ?>
        <a href="<?php echo YITH_WCWL()->get_wishlist_url(); ?>" class="wishlist-link <?php if ( $icon_style ) echo get_flatsome_icon_class( $icon_style, 'small' ); ?>">
            <i class="wishlist-icon icon-<?php echo get_theme_mod( 'wishlist_icon', 'heart' ); ?>"
			   <?php if ( YITH_WCWL()->count_products() > 0 ){ ?> data-icon-label="<?php echo YITH_WCWL()->count_products(); ?>" <?php } ?>>
            </i>
        </a>
    <?php if($icon_style) { ?> </div> <?php } ?>
</li>
