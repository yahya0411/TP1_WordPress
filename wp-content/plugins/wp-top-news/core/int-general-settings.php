<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
* Trait: General Settings
*/
trait Wtn_Int_General_Settings
{
    protected $fields, $settings, $options;
    
    protected function wtn_int_set_general_settings( $post ) {

        $this->fields   = $this->wtn_int_general_option_fileds();

        $this->options  = $this->wtn_build_set_settings_options( $this->fields, $post );

        $this->settings = apply_filters( 'wtn_general_settings', $this->options, $post );

        return update_option( 'wtn_general_settings', $this->settings );

    }

    protected function wtn_int_get_general_settings() {

        $this->fields   = $this->wtn_int_general_option_fileds();
		$this->settings = get_option('wtn_general_settings');
        
        return $this->wtn_build_get_settings_options( $this->fields, $this->settings );
	}

    protected function wtn_int_general_option_fileds() {

        return [
            [
                'name'      => 'wtn_int_news_sorting',
                'type'      => 'string',
                'default'   => 'menu_order',
            ],
            [
                'name'      => 'wtn_int_news_order',
                'type'      => 'string',
                'default'   => 'ASC',
            ],
            [
                'name'      => 'wtn_int_grid_columns',
                'type'      => 'number',
                'default'   => 2,
            ],
            [
                'name'      => 'wtn_int_news_number',
                'type'      => 'number',
                'default'   => 10,
            ],
            [
                'name'      => 'wtn_int_desc_length',
                'type'      => 'number',
                'default'   => 10,
            ],
            [
                'name'      => 'wtn_int_title_length',
                'type'      => 'number',
                'default'   => 5,
            ],
            [
                'name'      => 'wtn_int_enable_rtl',
                'type'      => 'boolean',
                'default'   => false,
            ],
            [
                'name'      => 'wtn_int_hide_date',
                'type'      => 'boolean',
                'default'   => false,
            ],
            [
                'name'      => 'wtn_display_pagination',
                'type'      => 'boolean',
                'default'   => false,
            ],
        ];
    }
}