<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
//print_r( $wtnGeneralSettings );
foreach ( $wtnGeneralSettings as $option_name => $option_value ) {
    if ( isset( $wtnGeneralSettings[$option_name] ) ) {
        ${"" . $option_name} = $option_value;
    }
}
$wtnDesc = '';
$wtn_news_arr = $this->wtn_get_api_data( 'news', $wtn_select_source, '' );
$wtn_news_init_stdclass = ( !empty($wtn_news_arr) ? $wtn_news_arr : [] );
//echo '<pre>';
//print_r($wtn_news_init_stdclass);
?>
<style>
.wtn-main-wrapper.<?php 
esc_attr_e( $wtn_layout );
?> {
    grid-template-columns: repeat(<?php 
esc_html_e( $wtn_grid_columns );
?>, 1fr);
    grid-gap: 25px;
}
<?php 
if ( $wtn_enable_rtl ) {
    ?>
    .wtn-main-wrapper.grid .wtn-item {
        text-align: right;
    }
    .wtn-main-wrapper.list .wtn-feed-container .wtn-img-container {
        margin-right: 0;
        margin-left: 20px;
    }
    <?php 
}
?>
@media(max-width:500px) {
    .wtn-main-wrapper.<?php 
esc_attr_e( $wtn_layout );
?> {
       grid-template-columns: repeat(1, 1fr);
    }
}
</style>
<?php 
if ( isset( $wtn_news_init_stdclass['totalResults'] ) && $wtn_news_init_stdclass['totalResults'] < $wtn_news_number ) {
    $wtn_news_number = $wtn_news_init_stdclass['totalResults'];
}

if ( !empty($wtn_news_init_stdclass) ) {
    
    if ( 'error' === $wtn_news_init_stdclass['status'] ) {
        esc_html_e( $wtn_news_init_stdclass['message'] );
    } else {
        
        if ( 0 === $wtn_news_init_stdclass['totalResults'] ) {
            _e( 'No news available right now!', 'wp-top-news' );
        } else {
            ?>
        <div class="wtn-main-wrapper <?php 
            esc_attr_e( $wtn_layout );
            ?>">
            <?php 
            for ( $i = 0 ;  $i < $wtn_news_number ;  $i++ ) {
                $wtn_news = ( isset( $wtn_news_init_stdclass['articles'][$i] ) ? (array) $wtn_news_init_stdclass['articles'][$i] : [] );
                
                if ( 'null' == $wtn_news['urlToImage'] ) {
                    $wtnImg = WTN_ASSETS . 'img/noimage.jpg';
                } else {
                    
                    if ( '' == $wtn_news['urlToImage'] ) {
                        $wtnImg = WTN_ASSETS . 'img/noimage.jpg';
                    } else {
                        $wtnImg = $wtn_news['urlToImage'];
                    }
                
                }
                
                $wtn_title = esc_html( wp_trim_words( $wtn_news['title'], $wtn_title_length, '...' ) );
                
                if ( '' != $wtn_news['description'] ) {
                    $wtn_description = esc_html( wp_trim_words( $wtn_news['description'], $wtn_desc_length, '...' ) );
                } else {
                    $wtn_description = esc_html( wp_trim_words( $wtn_news['content'], $wtn_desc_length, '...' ) );
                }
                
                if ( 'list' === $wtn_layout ) {
                    include WTN_PATH . 'view/list.php';
                }
                if ( 'grid' === $wtn_layout ) {
                    include WTN_PATH . 'view/grid.php';
                }
                if ( 'ticker' === $wtn_layout ) {
                    include WTN_PATH . 'view/ticker.php';
                }
            }
            ?>
        </div>
        <?php 
        }
    
    }

} else {
    _e( 'No Data Available', 'wp-top-news' );
}
