<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Create a helper function for easy SDK access.

if ( !function_exists( 'wtn_fs' ) ) {
    // Create a helper function for easy SDK access.
    function wtn_fs()
    {
        global  $wtn_fs ;
        
        if ( !isset( $wtn_fs ) ) {
            // Include Freemius SDK.
            require_once WTN_PATH . '/freemius/start.php';
            $wtn_fs = fs_dynamic_init( array(
                'id'             => '9048',
                'slug'           => 'wp-top-news',
                'type'           => 'plugin',
                'public_key'     => 'pk_cda42efe6097938ed803a6a4ef6d2',
                'is_premium'     => false,
                'premium_suffix' => 'Professional',
                'has_addons'     => false,
                'has_paid_plans' => true,
                'menu'           => array(
                'slug'       => 'edit.php?post_type=wtn_news',
                'first-path' => 'edit.php?post_type=wtn_news&page=wtn-how-it-works',
            ),
                'is_live'        => true,
            ) );
        }
        
        return $wtn_fs;
    }
    
    // Init Freemius.
    wtn_fs();
    // Signal that SDK was initiated.
    do_action( 'wtn_fs_loaded' );
    function wtn_fs_support_forum_url( $wp_support_url )
    {
        return 'https://wordpress.org/support/plugin/wp-top-news/';
    }
    
    wtn_fs()->add_filter( 'support_forum_url', 'wtn_fs_support_forum_url' );
    function wtn_fs_custom_connect_message_on_update(
        $message,
        $user_first_name,
        $plugin_title,
        $user_login,
        $site_link,
        $freemius_link
    )
    {
        return sprintf(
            __( 'Hey %1$s' ) . ',<br>' . __( 'Please help us improve %2$s! If you opt-in, some data about your usage of %2$s will be sent to %5$s. If you skip this, that\'s okay! %2$s will still work just fine.', 'wp-top-news' ),
            $user_first_name,
            '<b>' . $plugin_title . '</b>',
            '<b>' . $user_login . '</b>',
            $site_link,
            $freemius_link
        );
    }
    
    wtn_fs()->add_filter(
        'connect_message_on_update',
        'wtn_fs_custom_connect_message_on_update',
        10,
        6
    );
}
