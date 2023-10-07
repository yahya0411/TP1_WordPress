<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
* Trait: Ticker Styles Settings
*/
trait Wtn_Int_Ticker_Styles_Settings
{
    protected $fields, $settings, $options;
    
    protected function wtn_int_set_ticker_styles_settings( $post ) {

        $this->fields   = $this->wtn_int_ticker_styles_option_fileds();

        $this->options  = $this->wtn_build_set_settings_options( $this->fields, $post );

        $this->settings = apply_filters( 'wtn_int_ticker_styles_settings', $this->options, $post );

        return update_option( 'wtn_int_ticker_styles_settings', $this->settings );

    }

    protected function wtn_int_get_ticker_styles_settings() {

        $this->fields   = $this->wtn_int_ticker_styles_option_fileds();
		$this->settings = get_option('wtn_int_ticker_styles_settings');
        
        return $this->wtn_build_get_settings_options( $this->fields, $this->settings );
	}

    protected function wtn_int_ticker_styles_option_fileds() {

        return [
            [
                'name'      => 'wtn_ticker_label_bg_color',
                'type'      => 'text',
                'default'   => '#CC0000',
            ],
            [
                'name'      => 'wtn_ticker_label_font_color',
                'type'      => 'text',
                'default'   => '#FFFFFF',
            ],
            [
                'name'      => 'wtn_ticker_label_font_size',
                'type'      => 'number',
                'default'   => '12',
            ],
            [
                'name'      => 'wtn_ticker_content_bg_color',
                'type'      => 'text',
                'default'   => '#FFFFFF',
            ],
            [
                'name'      => 'wtn_ticker_content_font_color',
                'type'      => 'text',
                'default'   => '#222222',
            ],
            [
                'name'      => 'wtn_ticker_content_border_width',
                'type'      => 'text',
                'default'   => 1,
            ],
            [
                'name'      => 'wtn_ticker_content_border_color',
                'type'      => 'text',
                'default'   => '#CC0000',
            ],
        ];
    }
}