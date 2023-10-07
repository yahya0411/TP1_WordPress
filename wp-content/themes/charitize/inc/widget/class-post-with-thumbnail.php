<?php
/**
 * Class to register post with thumbnai widget
 */

class Charitize_Post_With_Thumb_Widget extends Charitize_Base_Widget{

	/**
	 * make needed options for widget
	 */

	public function __construct(){

		parent::__construct( 
			'post_with_thumbnail',
			esc_html__( 'ET: Recent Post With Thumbnail', 'charitize' )
		);

		$this->fields = array(
			'Charitize_pwt_title'=>array(
				'label'   => esc_html__( 'Title', 'charitize' ),
				'type'    => 'text',
				'default' => ''
			),
			'Charitize_pwt_number_of_post' => array(
				'label'   => esc_html__( 'Number of post', 'charitize' ),
				'type'    => 'number',
				'default' => 4
			),
			'Charitize_pwt_show_excerpt' => array(
				'label'   => esc_html__( 'Show Excerpt', 'charitize' ),
				'type'    => 'checkbox',
				'default' => true
			)
		);
	}

	/**
	 * Markup for widget
	 */
	public function widget( $args, $instance ){
		echo $args[ 'before_widget' ];
		
		$instance = $this->init_defaults( $instance );

		$recent_posts = wp_get_recent_posts(array(
		    'numberposts' => $instance[ 'Charitize_pwt_number_of_post' ],
		    'post_status' => 'publish',
		    'order' => 'DESC',
		    'orderby' => 'ID'
		));
		if( !empty( $recent_posts ) ){ ?>
			<div class="charitize-recent-posts-wrapper">
				<?php if( '' != $instance[ 'Charitize_pwt_title' ] ){ ?>
					<h2 class="widget-title charitize-widget-title"><?php echo esc_html( $instance[ 'Charitize_pwt_title' ] ); ?></h2>
				<?php } ?>
				<ul>
					<?php foreach ( $recent_posts as $p ) { ?>
						<li>
							<a href="<?php echo esc_url( get_the_permalink( $p[ 'ID' ] ) ); ?>">								
							
								<img src="<?php echo esc_url( get_the_post_thumbnail_url( $p[ 'ID' ], 'thumbnail' ) ); ?>" alt="" />
								<div class="charitize-pwt-content-wrappet">
									<h3><?php echo esc_html( get_the_title( $p[ 'ID' ] ) ); ?></h3>
									<div class="post-date"><?php self::the_date( $p[ 'ID' ] ); ?></div>
									<?php self::the_category( $p[ 'ID' ] ); ?>
									<?php if( $instance[ 'Charitize_pwt_show_excerpt' ] ){ ?>
										<p class="charitize-content"><?php the_excerpt(); ?></p>
									<?php } ?>
								</div>
							</a>
						</li>

					<?php } ?>				
				</ul>
			</div>
		<?php }
		echo $args[ 'after_widget' ];
	}
}