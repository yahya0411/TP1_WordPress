<?php
/**
 * Post navigation with support of jetpack
 *
 * @since 1.1.4
 *
 * @package Charitize
 */
add_action( 'charitize_action_posts_navigation', 'charitize_post_navigation');
if( !function_exists( 'charitize_post_navigation' ) ):
	function charitize_post_navigation(){

		$infinity_module_active = false;
		if( get_option( 'jetpack_active_modules' ) ){
			if( in_array( 'infinite-scroll', get_option( 'jetpack_active_modules' ) ) ){
				$infinity_module_active = true;
			}
		}
		
		if( defined( 'JETPACK__VERSION' ) && $infinity_module_active ){
		    return;
		} 
		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => esc_html__( 'Previous', 'charitize' ),
				'next_text' => esc_html__( 'Next', 'charitize' ),
			)
		);
	}
endif;