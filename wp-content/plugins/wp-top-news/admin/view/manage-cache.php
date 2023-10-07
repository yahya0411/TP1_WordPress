<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wtnShowMessage = false;

if ( isset( $_POST['updateSettings'] ) ) {
    $wtnShowMessage = $this->wtn_delete_transients_with_prefix('wtn_api_cached_data_');
}

if ( isset( $_POST['updateCachingTime'] ) ) {
    if ( ! isset( $_POST['wtn_cache_nonce_field'] ) 
        || ! wp_verify_nonce( $_POST['wtn_cache_nonce_field'], 'wtn_cache_action' ) ) {
        print 'Sorry, your nonce did not verify.';
        exit;
    } else {
        $wtn_caching_time   = isset( $_POST['wtn_caching_time'] ) ? sanitize_text_field( $_POST['wtn_caching_time'] ) : '24';
        $wtnShowMessage     = update_option( 'wtn_caching_time', $wtn_caching_time );
    }
}

$wtn_caching_time   = get_option('wtn_caching_time');
?>
<div id="wph-wrap-all" class="wrap">
    
    <div class="settings-banner">
        <h2><i class="fa fa-hdd" aria-hidden="true"></i>&nbsp;<?php _e('Manage Cache', 'wp-top-news'); ?></h2>
    </div>

    <?php 
    if ( $wtnShowMessage ) { 
        $this->wtn_display_notification( 'success', __( 'Cache Cleared Successfully', 'wp-top-news') );
    } 
    ?>

    <div class="wtn-wrap">

            <div class="wtn_personal_wrap wtn_personal_help" style="width: 75%; float: left; margin-top: 5px;">
                
                <form name="wpre-table" role="form" class="form-horizontal" method="post" action="" id="wtn-settings-form">
                    <p class="submit"><button id="updateSettings" name="updateSettings" class="button button-primary"><?php _e('Click Here to Clear Cache', 'wp-top-news'); ?></button></p>
                </form>
                
                <form name="wpre-table" role="form" class="form-horizontal" method="post" action="" id="wtn-caching-time-form">
                <?php wp_nonce_field( 'wtn_cache_action', 'wtn_cache_nonce_field' ); ?>
                    <table class="wtn-general-settings">
                    <tr>
                        <th scope="row">
                            <label><?php _e('Caching Time', 'wp-top-news'); ?>:</label>
                        </th>
                        <td>
                            <input type="radio" name="wtn_caching_time" id="wtn_caching_time_1" value="1" <?php if ( '1' === $wtn_caching_time ) { echo 'checked'; } ?>>
                            <label for="wtn_caching_time_1"><span></span><?php _e('1 Hour', 'wp-top-news'); ?></label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="wtn_caching_time" id="wtn_caching_time_6" value="6" <?php if ( '6' === $wtn_caching_time ) { echo 'checked'; } ?>>
                            <label for="wtn_caching_time_6"><span></span><?php _e('6 Hour', 'wp-top-news'); ?></label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="wtn_caching_time" id="wtn_caching_time_12" value="12" <?php if ( '12' === $wtn_caching_time ) { echo 'checked'; } ?>>
                            <label for="wtn_caching_time_12"><span></span><?php _e('12 Hour', 'wp-top-news'); ?></label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="wtn_caching_time" id="wtn_caching_time_24" value="24" <?php if ( '24' === $wtn_caching_time ) { echo 'checked'; } ?>>
                            <label for="wtn_caching_time_24"><span></span><?php _e('24 Hour', 'wp-top-news'); ?></label>
                        </td>
                    </tr>
                    </table>
                    <code><?php _e('For free API users we recommend to set caching time to 24 Hours', 'wp-top-news'); ?></code>
                    <hr>
                    <p class="submit">
                        <button id="updateCachingTime" name="updateCachingTime" class="button button-primary wtn-button">
                            <i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;<?php _e('Save Caching Time', 'wp-top-news'); ?>
                        </button>
                    </p>
                </form>
            </div>

            <?php
            $this->wtn_admin_sidebar();
            ?>

    </div>
</div>