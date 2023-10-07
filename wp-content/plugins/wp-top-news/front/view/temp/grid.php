<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wtn-item" style="<?php echo ! $wtn_int_enable_rtl ? 'text-align:left;' : ''; ?>">
    <div class="wtn-img-container">
        <div class="wtn-img" style="background-image: url('<?php esc_attr_e( $wtnImg ); ?>');" ></div>
    </div>
    <?php
    $wtnCatArray = array();
    foreach( $wtnCategories as $cat) {
        $wtnCatArray[] = "<span class='wtn-cats-link'><a href='" . esc_url( home_url( '/news-category/' . urlencode( $cat->slug )  ) ) . "' class='wtn-cats-link-a'>" . $cat->name . "</a></span>";
    }
    echo implode( '&nbsp;', $wtnCatArray );
    ?>
    <h2 class="wtn-news-title">
        <a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>" target="_blank">
            <?php esc_html_e( $wtn_title ); ?>
        </a>
    </h2>
    <span class="wtn-news-date">
        <?php
        if ( ! $wtn_int_hide_date ) {
            echo '<i class="fa fa-calendar-days"></i>&nbsp;&nbsp;' . get_the_date( 'F j, Y' );
        }
        ?>
    </span>
    <?php
    if ( $wtnDesc !== 'hide' ) {
        ?>
        <div class="wtn-news-description">
            <?php esc_html_e( $wtn_description ); ?>
            <a href="<?php echo esc_url( get_the_permalink( $post->ID ) ); ?>" target="_blank">
                <?php 
                echo _e( 'View More', 'wp-top-news' ) . '&nbsp;'; 
                if ( $wtn_int_enable_rtl ) {
                    echo '<i class="fa-solid fa-angles-left"></i>';
                } else {
                    echo '<i class="fa-solid fa-angles-right"></i>';
                }
                ?>
            </a>
        </div>
        <?php
    }
    ?>
</div>