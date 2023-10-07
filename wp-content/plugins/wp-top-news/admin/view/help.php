<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="wph-wrap-all" class="wrap wtn-general-settings-page">

    <div class="settings-banner">
        <h2><i class="fa-solid fa-headset"></i>&nbsp;<?php _e('How it works', 'wp-top-news'); ?></h2>
    </div>

    <div class="wtn-wrap">

        <div class="wtn_personal_wrap wtn_personal_help" style="width: 75%; float: left;">
            
            <div class="tab-content">

            <div class="help-link">
                <iframe width="800" height="450" src="https://www.youtube.com/embed/Iuia8BiJ7-c" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
                
                <table class="wtn-general-settings">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label>How Can I Display News?</label>
                            </th>
                            <td colspan="3">
                                After activating the plugin, you will see "News” in the Admin Dashboard Menu.
                                <br>
                                Go to “Add New Item” and add your News as many as you want.
                                <br>
                                Now you need to insert the shortcode <b>[wtn_news layout='grid/list']</b> at any page through TinyMCE editor.
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label>How Can I Display News From a Category?</label>
                            </th>
                            <td colspan="3">
                                Go to "News Categories” and add your Category first.
                                <br>
                                Now create a News item and assign that item to a News Categories available at right side panel.
                                <br>
                                Now you need to insert the shortcode <b>[wtn_news layout='grid/list' category="Category Name"]</b> at any page through TinyMCE editor.
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label>How Can I Display News With Certain Numbers?</label>
                            </th>
                            <td colspan="3">
                                You need to apply that shortcode <b>[wtn_news layout='grid/list' display=5]</b> to display only 5 News.
                            </td>
                        </tr>
                    </tbody>
                </table>
            
            </div>
        
        </div>
        
        <?php $this->wtn_admin_sidebar(); ?>

    </div>

</div>