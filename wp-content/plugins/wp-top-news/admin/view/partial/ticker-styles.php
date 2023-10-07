<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
//print_r( $wtnTickerStylesSettings );
foreach ( $wtnTickerStylesSettings as $option_name => $option_value ) {
    if ( isset( $wtnTickerStylesSettings[$option_name] ) ) {
        ${"" . $option_name} = $option_value;
    }
}
?>
<form name="wtn_general_settings_form" role="form" class="form-horizontal" method="post" action="" id="wtn-ticker-styles-settings-form">
<?php 
wp_nonce_field( 'wtn_ticker_style_action', 'wtn_ticker_style_nonce_field' );
?>
    <table class="wtn-general-settings">
        <tbody>
            <!-- Ticker Label -->
            <tr>
                <th scope="row" colspan="4" style="text-align:left;">
                    <hr><span><?php 
_e( 'Ticker Label', 'wp-top-news' );
?></span><hr>
                </th>
            </tr>
            <tr>
                <th scope="row">
                    <label><?php 
_e( 'Background Color', 'wp-top-news' );
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
                <th scope="row">
                    <label><?php 
_e( 'Font Color', 'wp-top-news' );
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
_e( 'Font Size', 'wp-top-news' );
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
            <!-- Ticker News -->
            <tr>
                <th scope="row" colspan="4" style="text-align:left;">
                    <hr><span><?php 
_e( 'Ticker Content', 'wp-top-news' );
?></span><hr>
                </th>
            </tr>
            <tr>
                <th scope="row">
                    <label><?php 
_e( 'Background Color', 'wp-top-news' );
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
                <th scope="row">
                    <label><?php 
_e( 'Font Color', 'wp-top-news' );
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
_e( 'Border Width', 'wp-top-news' );
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
                <th scope="row">
                    <label><?php 
_e( 'Border Color', 'wp-top-news' );
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
        </tbody>
    </table>
    <hr>
    <p class="submit">
        <button id="updateTickerStylesSettings" name="updateTickerStylesSettings" class="button button-primary wtn-button">
            <i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;<?php 
_e( 'Save Settings', 'wp-top-news' );
?>
        </button>
    </p>
</form>