<?php
/**
 * Carousel Design 1
 * 
 * @package Post Slider and Carousel
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="psac-post-carousel-slide">
	<div class="psac-post-image-bg" style="<?php echo esc_attr($image_bg_css); ?>">
	<a href="<?php echo esc_url( $post_link ); ?>" class="psac-link-overlay"></a>
		<div class="psac-post-carousel-content">
		<?php if($show_category && $cate_name !='') { ?>
			<div class="psac-post-categories">
				<?php echo wp_kses_post($cate_name); ?>
			</div>
			<?php } ?>

			<h2 class="psac-post-title">
				<a href="<?php echo esc_url( $post_link ); ?>"><?php the_title(); ?></a>
			</h2>

			<?php if($show_date || $show_author || $show_comments) { ?>
				<div class="psac-post-meta">
					<?php if($show_author) { ?>
						<span class="psac-post-meta-innr psac-user-img"><?php the_author(); ?></span>
					<?php } ?>
					<?php echo ($show_author && $show_date) ? '<span class="psac-sep">/</span>' : '';
					
					if($show_date) { ?>
						<span class="psac-post-meta-innr psac-time"> <?php echo get_the_date(); ?> </span>
					<?php }

					echo ($show_author && $show_date && $show_comments && !empty($comments)) ? '<span class="psac-sep">/</span>' : '';
					
					if(!empty($comments) && $show_comments) { ?>
						<span class="psac-post-meta-innr psac-post-comments">
							<a href="<?php the_permalink(); ?>#comments"><?php echo esc_html($comments.' '.$reply); ?></a>
						</span>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
	<?php if( $show_content ) { ?>
		<div class="psac-post-content">
			<div class="psac-post-short-content"><?php echo psac_get_post_excerpt( $post->ID, get_the_content(), $words_limit ); ?></div>
			<?php if( $show_read_more ) { ?>
				<a href="<?php echo esc_url( $post_link ); ?>" class="psac-readmorebtn"><?php esc_html_e('Read More', 'post-slider-and-carousel'); ?></a>
			<?php } ?>
		</div>
	<?php }

	if( ! empty($tags) && $show_tags) { ?>
		<div class="psac-post-tags"><?php echo wp_kses_post($tags); ?></div>
	<?php } ?>
</div>