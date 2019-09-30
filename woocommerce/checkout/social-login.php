<div class="text-left social-login pb-half pt-half">
	<?php if( is_nextend_facebook_login() && get_option('woocommerce_enable_myaccount_registration')=='yes' && !is_user_logged_in())  {
		$facebook_url = add_query_arg( array( 'loginFacebook' => 1, 'redirect' => rawurlencode( get_permalink() ) ), wp_login_url() );
		?>
		<a href="<?php echo esc_url( $facebook_url ); ?>"
		class="button social-button large facebook circle"
		onclick="window.location = '<?php echo esc_url( $facebook_url ); ?>'+window.location.href; return false;"><i class="icon-facebook"></i>
		<span><?php _e('Login with <strong>Facebook</strong>','flatsome'); ?></span></a>
	<?php } ?>

	<?php if( is_nextend_google_login() && get_option('woocommerce_enable_myaccount_registration')=='yes' && !is_user_logged_in())  {
		$google_url = add_query_arg( array( 'loginGoogle' => 1, 'redirect' => rawurlencode( get_permalink() ) ), wp_login_url() );
		?>
		<a class="button social-button large google-plus circle"
		href="<?php echo esc_url( $google_url ); ?>"
		onclick="window.location = '<?php echo esc_url( $google_url ); ?>'+window.location.href; return false;">
		<i class="icon-google-plus"></i>
		<span><?php _e('Login with <strong>Google</strong>','flatsome'); ?></span></a>
	<?php } ?>
</div>
