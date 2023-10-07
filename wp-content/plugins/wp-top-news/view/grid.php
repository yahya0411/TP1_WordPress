<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wtn-item">
    <div class="wtn-img-container">
        <div class="wtn-img" style="background-image: url('<?php esc_attr_e( $wtnImg ); ?>');" ></div>
    </div>
    <?php
    if ( '1' === $wtn_display_news_source ) {
        $wtn_source = (array) $wtn_news['source'];
        ?>
        <span class="wtn-cats-link">
            <a href="#" class="wtn-cats-link-a">
                <?php 
                echo '<i class="fa fa-newspaper"></i>&nbsp;&nbsp;' . esc_html( $wtn_source['name'] );
                ?>
            </a>
        </span>
        <?php
    }
    ?>
    <h2 class="wtn-news-title">
        <a href="<?php echo esc_url( $wtn_news['url'] ); ?>" target="_blank"><?php esc_html_e( $wtn_title ); ?></a>
    </h2>
    <span class="wtn-news-date">
        <?php
        if ( '1' === $wtn_display_date ) {
            echo '<i class="fa fa-calendar-days"></i>&nbsp;&nbsp;' . date( 'd M, Y', strtotime( $wtn_news['publishedAt'] ) );
        }
        ?>
    </span>
    <?php
    if ( $wtnDesc !== 'hide' ) {
        ?>
        <div class="wtn-news-description">
            <?php esc_html_e( $wtn_description ); ?>
            <a href="<?php echo esc_url( $wtn_news['url'] ); ?>" target="_blank">
                <?php 
                echo _e( 'View More', 'wp-top-news' ) . '&nbsp;'; 
                if ( $wtn_enable_rtl ) {
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