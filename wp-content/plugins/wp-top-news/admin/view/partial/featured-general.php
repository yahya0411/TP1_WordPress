<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
//print_r( $wtnSettingsContent );
foreach ( $wtnSettingsContent as $option_name => $option_value ) {
    if ( isset( $wtnSettingsContent[$option_name] ) ) {
        ${"" . $option_name} = $option_value;
    }
}
?>
<form name="wtn_general_settings_form" role="form" class="form-horizontal" method="post" action="" id="wtn-general-settings-form">
<?php 
wp_nonce_field( 'wtn_featured_content_action', 'wtn_featured_content_nonce_field' );
?>
    <table class="wtn-general-settings">
        <tbody>
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Title Word Length', 'wp-top-news' );
?></label>
            </th>
            <td>
                <?php 
?>
                    <span><?php 
echo  '<a href="' . wtn_fs()->get_upgrade_url() . '">' . __( 'Please Upgrade Now!', 'wp-top-news' ) . '</a>' ;
?></span>
                    <?php 
?>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="wtn_display_featured_today"><?php 
_e( 'Display Only Todays', 'wp-top-news' );
?></label>
            </th>
            <td>
                <?php 
?>
                    <span><?php 
echo  '<a href="' . wtn_fs()->get_upgrade_url() . '">' . __( 'Please Upgrade Now!', 'wp-top-news' ) . '</a>' ;
?></span>
                    <?php 
?>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label><?php 
_e( 'Number of News', 'wp-top-news' );
?></label>
            </th>
            <td>
                <?php 
?>
                    <span><?php 
echo  '<a href="' . wtn_fs()->get_upgrade_url() . '">' . __( 'Please Upgrade Now!', 'wp-top-news' ) . '</a>' ;
?></span>
                    <?php 
?>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="wtn_shortcode"><?php 
_e( 'Shortcode', 'wp-top-news' );
?></label>
            </th>
            <td>
                <input type="text" name="wtn_shortcode" id="wtn_shortcode" class="regular-text" value="[wtn_news_featured]" readonly />
                <code><?php 
_e( 'Use this shortcode to display featured news.', 'wp-top-news' );
?></code>
            </td>
        </tr>
        </tbody>
    </table>
    <hr>
    <p class="submit">
        <button id="updateGeneralSettings" name="updateGeneralSettings" class="button button-primary wtn-button">
            <i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;<?php 
_e( 'Save Settings', 'wp-top-news' );
?>
        </button>
    </p>
</form>