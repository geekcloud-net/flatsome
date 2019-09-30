<?php

function flatsome_facebook_oauth_url() {
  $client_id = '380204239234502';
  $base_url = 'https://www.facebook.com/v4.0/dialog/oauth';
  $redirect_uri = flatsome_api_url() . '/facebook/authorize/';
  $scope = 'manage_pages,instagram_basic,public_profile';
  $nonce = wp_create_nonce( 'flatsome_facebook_connect_' . get_current_user_id() );
  $config = "optionsframework|of-option-instagram|$nonce";
  $return_uri = admin_url( "admin-ajax.php?flatsome_facebook_connect=$config" );
  $state = urlencode( $return_uri );
  $response_type = 'code';

  return "$base_url?client_id=$client_id&response_type=$response_type&scope=$scope&redirect_uri=$redirect_uri&state=$state";
}

function flatsome_facebook_login_button_html() {
  $url = flatsome_facebook_oauth_url();
  ob_start(); ?>

  <hr />
  <p><?php _e('Login with Facebook to connect an Instagram Business account:')  ?></p>
  <a class="button" style="padding: 5px 15px; height: auto; background-color: #4267b2; border-color: #4267b2; color: #ffffff;" href="<?php echo $url ?>">
    <span class="dashicons dashicons-facebook-alt" style="vertical-align: middle; margin-top: -2px;"></span>
    <?php _e( 'Login with Facebook', 'flatsome-admin' ) ?>
  </a>
  <p>
    <a href="https://docs.uxthemes.com/article/379-how-to-connect-to-instagram-api" target="_blank" rel="noopener noreferrer">
      <?php _e( 'How to setup an Instagram Business account', 'flatsome-admin' ) ?>
    </a>
  </p>
  <?php return ob_get_clean();
}

function flatsome_facebook_accounts_html() {
  $accounts = flatsome_facebook_accounts();

  ob_start(); ?>

  <input type="hidden" value="0" name="facebook_accounts[]">

  <div class="theme-browser">
    <div class="themes wp-clearfix">
      <?php if ( empty( $accounts ) ) : ?>
        <div class="notice notice-info inline">
          <p><?php _e('No accounts connected yet...')  ?></p>
        </div>
      <?php else: ?>
      <?php foreach ( $accounts as $username => $account ) : ?>
      <div class="theme instagram-account instagram-account--<?php echo esc_attr( $username ) ?>" style="width: 46%">
        <input type="hidden" value="<?php echo esc_attr( $account['id'] ) ?>" name="facebook_accounts[<?php echo esc_attr( $username ) ?>]">
        <div class="theme-screenshot">
          <img src="<?php echo esc_attr( $account['profile_picture'] ) ?>" alt="<?php echo esc_attr( $username ) ?>">
        </div>
        <!-- <div class="notice inline notice-alt"><p></p></div> -->
        <div class="theme-id-container">
          <h2 class="theme-name">
            <a target="_blank" href="https://www.instagram.com/<?php echo esc_attr( $username ) ?>/">
              <?php echo esc_html( $username ) ?>
            </a>
            <code style="background: transparent; opacity: 0.5">
              <small><?php echo substr( $account['access_token'], -7, 7 ) ?></small>
            </code>
          </h2>
          <div class="theme-actions">
            <button type="button" class="button button-small" onclick="jQuery('.instagram-account--<?php echo esc_attr( $username ) ?>').remove()">
              Disconnect
            </button>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <?php return ob_get_clean();
}

function flatsome_facebook_set_theme_mod( $values, $old_values ) {
  $result = array();

  foreach ( $values as $username => $id ) {
    if ( is_array( $old_values ) && array_key_exists( $username, $old_values ) ) {
      $result[ $username ] = $old_values[ $username ];
    } else {
      $result[ $username ] = $id;
    }
  }

  return $result;
}
add_filter( 'pre_set_theme_mod_facebook_accounts', 'flatsome_facebook_set_theme_mod', 10, 2 );

function flatsome_facebook_connect() {
  $action = 'flatsome_facebook_connect_' . get_current_user_id();

  if ( wp_verify_nonce( $_POST['nonce'], $action ) ) {
    $page = sanitize_text_field( $_POST['page'] );
    $section = sanitize_text_field( $_POST['section'] );
    $account = array_map( 'sanitize_text_field', $_POST['account'] );
    $account['permissions'] = array( 'manage_pages', 'instagram_basic', 'public_profile' );

    $accounts = flatsome_facebook_accounts();
    $accounts[ $account['username'] ] = $account;

    set_theme_mod( 'facebook_accounts', $accounts );

    wp_redirect(
      admin_url( "admin.php?page=$page#$section" )
    );

    die;
  }

  header( 'HTTP/1.1 401 Unauthorized' );
  wp_die( 'forbidden' );
}
add_action( 'wp_ajax_flatsome_facebook_connect', 'flatsome_facebook_connect' );
