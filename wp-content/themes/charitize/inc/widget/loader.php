<?php 

require_once( get_template_directory() . '/inc/widget/class-base-widget.php' );
require_once( get_template_directory() . '/inc/widget/class-post-with-thumbnail.php' );
require_once( get_template_directory() . '/inc/widget/class-profile-card.php' );
function Charitize_register_widget(){
	$st_widgets = array(
		'Charitize_Post_With_Thumb_Widget',
		'Charitize_Profile_Card_Widget'
	);
	foreach ( $st_widgets as $widget ) {			
		register_widget( $widget );
	}
}
add_action( 'widgets_init', 'Charitize_register_widget' );

function Charitize_widget_scripts(){
	// widget style
	wp_enqueue_style( 'widget', get_template_directory_uri() . '/inc/widget/assets/widget.css' );
}
add_action( 'wp_enqueue_scripts', 'Charitize_widget_scripts' );