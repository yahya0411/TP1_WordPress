<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wtnShowMessage = false;

if ( isset( $_POST['updateSettings'] ) ) {
     if ( ! isset( $_POST['wtn_api_nonce_field'] ) 
          || ! wp_verify_nonce( $_POST['wtn_api_nonce_field'], 'wtn_api_action' ) ) {
          print 'Sorry, your nonce did not verify.';
          exit;
     } else {
          $wtn_api_key        = isset( $_POST['wtn_api_key'] ) ? sanitize_text_field( $_POST['wtn_api_key'] ) : '';
          $wtnShowMessage     = update_option( 'wtn_api_key', $wtn_api_key );
     }
}

$wtn_api_key   = get_option('wtn_api_key');
?>
<div id="wph-wrap-all" class="wrap">
     
     <div class="settings-banner">
          <h2><i class="fa fa-key" aria-hidden="true"></i>&nbsp;<?php _e('API Key Settings', 'wp-top-news'); ?></h2>
     </div>

     <?php 
     if ( $wtnShowMessage ) { 
          $this->wtn_display_notification('success', 'Your information updated successfully'); 
     } 
     ?>

     <div class="wtn-wrap">

          <div class="wtn_personal_wrap wtn_personal_help" style="width: 75%; float: left; margin-top: 5px;">

               <form name="wpre-table" role="form" class="form-horizontal" method="post" action="" id="wtn-settings-form">
               <?php wp_nonce_field( 'wtn_api_action', 'wtn_api_nonce_field' ); ?>
                    <table class="wtn-key-settings">
                    <tr class="wtn_api_key">
                         <th scope="row">
                              <label for="wtn_api_key"><?php _e('API Key', 'wp-top-news'); ?>:</label>
                         </th>
                         <td>
                              <input type="text" name="wtn_api_key" class="regular-text" value="<?php esc_attr_e( $wtn_api_key ); ?>">
                              <code><?php _e('Get your API key from', 'wp-top-news'); ?>&nbsp;<a href="<?php echo esc_url('https://newsapi.org/'); ?>" target="_blank"><?php _e('here', 'wp-top-news'); ?></a></code>
                         </td>
                    </tr>
                    </table>
                    <hr>
                    <p class="submit">
                         <button id="updateSettings" name="updateSettings" class="button button-primary wtn-button">
                              <i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;<?php _e('Save Settings', 'wp-top-news'); ?>
                         </button>
                    </p>
               </form>
               *Note: We do not have any business connection or benifit from newsapi. So you have your own decision to buy or use free API from them.<br>
               Please <a href="<?php echo esc_url('https://newsapi.org/pricing'); ?>" target="_blank"><?php _e('read', 'wp-top-news'); ?></a> the free plan limitations carefully.
               Our <strong>PROFESSIONAL</strong> plan will not cover the limitations, news availability, news updates etc.
          </div>

          <?php
               $this->wtn_admin_sidebar();
          ?>

     </div>
</div>