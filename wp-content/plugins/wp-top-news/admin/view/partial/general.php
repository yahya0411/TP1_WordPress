<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//print_r( $wtnSettingsContent );
foreach ( $wtnSettingsContent as $option_name => $option_value ) {
    if ( isset( $wtnSettingsContent[$option_name] ) ) {
        ${"" . $option_name}  = $option_value;
    }
}
?>
<form name="wtn_general_settings_form" role="form" class="form-horizontal" method="post" action="" id="wtn-general-settings-form">
<?php wp_nonce_field( 'wtn_general_content_action', 'wtn_general_content_nonce_field' ); ?>
    <table class="wtn-general-settings">
        <tbody>
        <tr>
            <th scope="row">
                <label><?php _e('Order With', 'wp-top-news'); ?>:</label>
            </th>
            <td>
                <select name="wtn_int_news_sorting" class="medium-text">
                    <option value="">--<?php _e('Select One', 'wp-top-news'); ?>--</option>
                    <option value="title" <?php echo ( 'title' === $wtn_int_news_sorting ) ? 'selected' : ''; ?> ><?php _e('Name', 'wp-top-news'); ?></option>
                    <option value="date" <?php echo ( 'date' === $wtn_int_news_sorting ) ? 'selected' : ''; ?> ><?php _e('Date', 'wp-top-news'); ?></option>
                    <option value="menu_order" <?php echo ( 'menu_order' === $wtn_int_news_sorting ) ? 'selected' : ''; ?> ><?php _e('Post Order', 'wp-top-news'); ?></option>
                </select>
            </td>
            <th scope="row" style="text-align: right;">
                <label><?php _e('Order By', 'wp-top-news'); ?>:</label>
            </th>
            <td>
                <input type="radio" name="wtn_int_news_order" id="wtn_int_news_order_a" value="ASC" <?php echo ( 'ASC' === $wtn_int_news_order ) ? 'checked' : ''; ?> >
                <label for="wtn_int_news_order_a"><span></span><?php _e( 'Ascending', 'wp-top-news' ); ?></label>
                    &nbsp;&nbsp;
                <input type="radio" name="wtn_int_news_order" id="wtn_int_news_order_d" value="DESC" <?php echo ( 'DESC' === $wtn_int_news_order ) ? 'checked' : ''; ?> >
                <label for="wtn_int_news_order_d"><span></span><?php _e( 'Descending', 'wp-top-news' ); ?></label>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="wtn_int_enable_rtl"><?php _e('Enable RTL', 'wp-top-news'); ?>?</label>
            </th>
            <td colspan="3">
                <input type="checkbox" name="wtn_int_enable_rtl" id="wtn_int_enable_rtl" value="1" <?php echo $wtn_int_enable_rtl ? 'checked' : ''; ?>>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label><?php _e('News Per Page', 'wp-top-news'); ?></label>
            </th>
            <td>
                <input type="number" name="wtn_int_news_number" class="medium-text" min="1" max="100" step="1" value="<?php esc_attr_e( $wtn_int_news_number ); ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="wtn_display_pagination"><?php _e('Display Pagination', 'wp-top-news'); ?>?</label>
            </th>
            <td>
                <input type="checkbox" name="wtn_display_pagination" id="wtn_display_pagination" value="1" <?php echo $wtn_display_pagination ? 'checked' : ''; ?>>
            </td>
        </tr>
        </tbody>
    </table>
    <hr>
    <p class="submit">
        <button id="updateGeneralSettings" name="updateGeneralSettings" class="button button-primary wtn-button">
            <i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;<?php _e('Save Settings', 'wp-top-news'); ?>
        </button>
    </p>
</form>