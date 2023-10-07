<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
* Trait: Content Settings
*/
trait Wtn_Int_Ticker_Content_Settings
{
    protected $fields, $settings, $options;
    
    protected function wtn_int_set_ticker_content_settings( $post ) {

        $this->fields   = $this->wtn_int_ticker_content_option_fileds();

        $this->options  = $this->wtn_build_set_settings_options( $this->fields, $post );

        $this->settings = apply_filters( 'wtn_int_ticker_content_settings', $this->options, $post );

        return update_option( 'wtn_int_ticker_content_settings', $this->settings );

    }

    protected function wtn_int_get_ticker_content_settings() {

        $this->fields   = $this->wtn_int_ticker_content_option_fileds();
		$this->settings = get_option('wtn_int_ticker_content_settings');
        
        return $this->wtn_build_get_settings_options( $this->fields, $this->settings );
	}

    protected function wtn_int_ticker_content_option_fileds() {

        return [
            [
                'name'      => 'wtn_display_ticker_today',
                'type'      => 'boolean',
                'default'   => false,
            ],
            [
                'name'      => 'wtn_ticker_news_number',
                'type'      => 'number',
                'default'   => 5,
            ],
            [
                'name'      => 'wtn_ticker_label_text',
                'type'      => 'text',
                'default'   => 'Breaking News',
            ],
            [
                'name'      => 'wtn_ticker_type',
                'type'      => 'string',
                'default'   => 'marquee',
            ],
        ];
    }
}