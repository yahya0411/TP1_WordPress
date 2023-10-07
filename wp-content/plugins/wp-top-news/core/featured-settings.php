<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
* Trait: General Settings
*/
trait Wtn_Int_Featured_General_Settings
{
    protected $fields, $settings, $options;
    
    protected function wtn_int_set_featured_general_settings( $post ) {

        $this->fields   = $this->wtn_int_featured_general_option_fileds();

        $this->options  = $this->wtn_build_set_settings_options( $this->fields, $post );

        $this->settings = apply_filters( 'wtn_int_featured_content_settings', $this->options, $post );

        return update_option( 'wtn_int_featured_content_settings', $this->settings );

    }

    protected function wtn_int_get_featured_general_settings() {

        $this->fields   = $this->wtn_int_featured_general_option_fileds();
		$this->settings = get_option('wtn_int_featured_content_settings');
        
        return $this->wtn_build_get_settings_options( $this->fields, $this->settings );
	}

    protected function wtn_int_featured_general_option_fileds() {

        return [
            [
                'name'      => 'wtn_featured_title_length',
                'type'      => 'number',
                'default'   => 5,
            ],
            [
                'name'      => 'wtn_display_featured_today',
                'type'      => 'boolean',
                'default'   => false,
            ],
            [
                'name'      => 'wtn_featured_news_number',
                'type'      => 'number',
                'default'   => 5,
            ],
        ];
    }
}