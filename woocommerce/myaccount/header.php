<?php
$is_facebook_login = is_nextend_facebook_login();
$is_google_login   = is_nextend_google_login();

$login_text = flatsome_option( 'facebook_login_text' );
$login_bg   = flatsome_option( 'facebook_login_bg' );
$login_bg   = $login_bg ? 'style="background-image:url(' . do_shortcode( $login_bg ) . ')"' : '';

global $wp;
$endpoint_label = '';
$current_url    = home_url( $wp->request );

// Collect current WC endpoint label.
if ( function_exists( 'wc_get_account_menu_items' ) && get_theme_mod( 'wc_account_links', 1 ) ) {
	foreach ( wc_get_account_menu_items() as $endpoint => $label ) {
		if ( untrailingslashit( wc_get_account_endpoint_url( $endpoint ) ) === $current_url ) {
			$endpoint_label = $label;
			break;
		}
	}
}
?>

<div class="my-account-header page-title normal-title
	<?php if ( $login_bg ) echo 'dark featured-title'; ?>">

	<?php if ( $login_bg ) { ?>
		<div class="page-title-bg fill bg-fill" <?php echo $login_bg; ?>>
			<div class="page-title-bg-overlay fill"></div>
		</div>
	<?php } ?>

	<div class="page-title-inner flex-row  container">
		<div class="flex-col flex-grow <?php if ( get_theme_mod( 'logo_position' ) == 'center' ) { echo 'text-center'; } else { echo 'medium-text-center'; } ?>">
			<?php if ( is_user_logged_in() ) : ?>

				<h1 class="uppercase mb-0"><?php the_title(); ?></h1>
				<?php if ( ! empty ( $endpoint_label ) ) echo '<small class="uppercase">' . esc_html( $endpoint_label ) . '</small>'; ?>

			<?php else : ?>
				
				<div class="text-center social-login">
					<?php if ( ! $is_facebook_login && ! $is_google_login ) {
						echo '<h1 class="uppercase mb-0">' . get_the_title() . '</h1>';
					} ?>

					<?php if ( $is_facebook_login && get_option( 'woocommerce_enable_myaccount_registration' ) == 'yes' && ! is_user_logged_in() ) {
						$facebook_url = add_query_arg( array( 'loginFacebook' => 1, 'redirect' => rawurlencode( get_permalink() ) ), wp_login_url() );
						?>
						<a href="<?php echo esc_url( $facebook_url ); ?>"
						   class="button social-button large facebook circle"
						   onclick="window.location = '<?php echo esc_url( $facebook_url ); ?>'+window.location.href return false"><i class="icon-facebook"></i>
							<span><?php _e( 'Login with <strong>Facebook</strong>', 'flatsome' ); ?></span></a>
					<?php } ?>

					<?php if ( $is_google_login && get_option( 'woocommerce_enable_myaccount_registration' ) == 'yes' && ! is_user_logged_in() ) {
						$google_url = add_query_arg( array( 'loginGoogle' => 1, 'redirect' => rawurlencode( get_permalink() ) ), wp_login_url() );
						?>
						<a class="button social-button large google-plus circle"
						   href="<?php echo esc_url( $google_url ); ?>"
						   onclick="window.location = '<?php echo esc_url( $google_url ); ?>'+window.location.href return false">
							<i class="icon-google-plus"></i>
							<span><?php _e( 'Login with <strong>Google</strong>', 'flatsome' ); ?></span></a>
					<?php } ?>


					<?php if ( $login_text ) { ?><p><?php echo do_shortcode( $login_text ); ?></p><?php } ?>
				</div>

			<?php endif; ?>
		</div><!-- .flex-left -->
	</div><!-- flex-row -->
</div><!-- .page-title -->
