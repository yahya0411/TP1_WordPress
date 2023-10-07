<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wtn-feed-container">
    <div class="wtn-img-container">
        <div class="wtn-img" style="background-image: url('<?php esc_attr_e( $wtnImg ); ?>');" ></div>
    </div>
    <div class="wtn-feeds">
        <h2 class="wtn-news-title">
            <a href="<?php echo esc_url( $wtn_news['url'] ); ?>" target="_blank" class="wtn-feeds-title">
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
        <span class="wtn-news-date" style="line-height: 20px;">
            <?php
            if ( $wtn_enable_rtl ) {
                if ( '1' === $wtn_display_date ) {
                    echo '<i class="fa fa-calendar-days"></i>&nbsp;&nbsp;' . date( 'd M, Y', strtotime( $wtn_news['publishedAt'] ) ) . '<br>';
                }
                if ( '1' === $wtn_display_news_source ) {
                    $wtn_source = (array) $wtn_news['source'];
                    echo '<i class="fa fa-newspaper"></i>&nbsp;&nbsp;' . esc_html( $wtn_source['name'] );
                }
            } else {
                if ( '1' === $wtn_display_date ) {
                    echo '<i class="fa fa-calendar-days"></i>&nbsp;&nbsp;' . date( 'd M, Y', strtotime( $wtn_news['publishedAt'] ) ) . '<br>';
                }
                if ( '1' === $wtn_display_news_source ) {
                    $wtn_source = (array) $wtn_news['source'];
                    echo '<i class="fa fa-newspaper"></i>&nbsp;&nbsp;' . esc_html( $wtn_source['name'] );
                }
            }
            ?>
        </span>
    </div>
</div>