<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
/**
*	Front CLass
*/
class WTN_Front
{
    use 
        Wtn_API,
        Wtn_Core,
        Wtn_General_Settings,
        Wtn_Int_General_Settings,
        Wtn_Int_Featured_General_Settings,
        Wtn_Int_Ticker_Content_Settings,
        Wtn_Int_Ticker_Styles_Settings
    ;
    protected  $wtn_vrsn ;
    protected  $wtn_api_cached_data, $wtn_api, $wtn_api_data ;
    function __construct( $version )
    {
        $this->wtn_vrsn = $version;
        $this->wtn_assets_prefix = substr( WTN_PRFX, 0, -1 ) . '-';
    }
    
    // Adding styles and js
    function wtn_front_assets()
    {
        wp_enqueue_style(
            $this->wtn_assets_prefix . 'font-awesome',
            WTN_ASSETS . 'css/fontawesome/css/all.min.css',
            array(),
            $this->wtn_vrsn,
            FALSE
        );
        wp_enqueue_style(
            $this->wtn_assets_prefix . 'front',
            WTN_ASSETS . 'css/' . $this->wtn_assets_prefix . 'front.css',
            array(),
            $this->wtn_vrsn
        );
        if ( !wp_script_is( 'jquery' ) ) {
            wp_enqueue_script( 'jquery' );
        }
        wp_enqueue_script(
            'wtn-acmeticker',
            WTN_ASSETS . 'js/acmeticker.min.js',
            [ 'jquery' ],
            $this->wtn_vrsn,
            true
        );
        wp_enqueue_script(
            'wtn-front',
            WTN_ASSETS . 'js/wtn-front.js',
            [ 'jquery' ],
            $this->wtn_vrsn,
            true
        );
    }
    
    function wtn_load_shortcode()
    {
        add_shortcode( 'wp_top_news', array( $this, 'wtn_external_news_shortcode_view' ) );
        add_shortcode( 'wtn_news', array( $this, 'wtn_internal_news_shortcode_view' ) );
    }
    
    public function wtn_external_news_shortcode_view( $wtnAttr )
    {
        $wtnGeneralSettings = $this->wtn_get_general_settings();
        $output = '';
        ob_start();
        include WTN_PATH . 'front/view/external.php';
        $output .= ob_get_clean();
        return $output;
    }
    
    public function wtn_internal_news_shortcode_view( $wtnAttr )
    {
        $wtnGeneralSettings = $this->wtn_int_get_general_settings();
        $output = '';
        ob_start();
        include WTN_PATH . 'front/view/internal.php';
        $output .= ob_get_clean();
        return $output;
    }
    
    public function wtn_internal_shortcode_ticker_view( $wtnAttr )
    {
        $wtnTickerContentSettings = $this->wtn_int_get_ticker_content_settings();
        $wtnTickerStylesSettings = $this->wtn_int_get_ticker_styles_settings();
        $output = '';
        ob_start();
        include WTN_PATH . 'front/view/ticker.php';
        $output .= ob_get_clean();
        return $output;
    }
    
    function wtn_internal_shortcode_hero_view( $wtnAttr )
    {
        //$wtnTickerContentSettings = $this->wtn_int_get_ticker_content_settings();
        //$wtnTickerStylesSettings = $this->wtn_int_get_ticker_styles_settings();
        $output = '';
        ob_start();
        include WTN_PATH . 'front/view/hero.php';
        $output .= ob_get_clean();
        return $output;
    }
    
    function wtn_internal_shortcode_featured_view( $wtnAttr )
    {
        $wtnGeneralSettings = $this->wtn_int_get_featured_general_settings();
        $output = '';
        ob_start();
        include WTN_PATH . 'front/view/featured.php';
        $output .= ob_get_clean();
        return $output;
    }

}