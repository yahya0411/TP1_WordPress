<?php
class Charitize_Profile_Card_Widget extends Charitize_Base_Widget{

	/**
	 * make needed options for widget
	 *
	 */
	public function __construct(){

		parent::__construct( 
			'st_profile_card',
			esc_html__( 'ET: Profile Card', 'charitize' )
		);

		$users_array = self::get_users_list();

		$this->fields = array(
			'user_id' => array(
				'label'   => esc_html__( 'Select Username', 'charitize' ),
				'type'    => 'select',
				'default' => 1,
				'choices' => $users_array
			),
		);
	}

	/**
	 * Markup for widget
	 */
	public function widget( $args, $instance ){
		echo $args[ 'before_widget' ];
		
		$instance = $this->init_defaults( $instance );
		self::the_profile_card( $instance[ 'user_id' ] );
		
		echo $args[ 'after_widget' ];
	}
}