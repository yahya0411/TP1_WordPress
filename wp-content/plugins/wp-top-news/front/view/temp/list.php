<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wtn-feed-container">
    <div class="wtn-img-container" style="<?php echo ! $wtn_int_enable_rtl ? 'margin-right:20px; margin-left:0;' : ''; ?>">
        <div class="wtn-img" style="background-image: url('<?php esc_attr_e( $wtnImg ); ?>');" ></div>
    </div>  
    <div class="wtn-feeds">
        <h2 class="wtn-news-title">
            <a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>" target="_blank" class="wtn-feeds-title">
                <?php esc_html_e( $wtn_title ); ?>
            </a>
        </h2>
        <?php
        if ( $wtnDesc !== 'hide' ) {
            ?>
            <p class="wtn-feeds-description">
                <?php esc_html_e( $wtn_description ); ?>
            </p>
            <?php
        }
        ?>
        <span class="wtn-news-date">
            <?php echo '<i class="fa-solid fa-calendar-days"></i>&nbsp;&nbsp;' . get_the_date( 'F j, Y' ); ?>
        </span>
    </div>
</div>