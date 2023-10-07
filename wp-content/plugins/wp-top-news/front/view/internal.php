<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
global  $post ;
//print_r( $wtnGeneralSettings );
foreach ( $wtnGeneralSettings as $option_name => $option_value ) {
    if ( isset( $wtnGeneralSettings[$option_name] ) ) {
        ${"" . $option_name} = $option_value;
    }
}
$wtn_layout = ( isset( $wtnAttr['layout'] ) ? $wtnAttr['layout'] : '' );
$wtn_category = ( isset( $wtnAttr['category'] ) ? $wtnAttr['category'] : '' );
$wtnDesc = ( isset( $wtnAttr['description'] ) ? $wtnAttr['description'] : '' );
// description="hide" to hide description
$wtn_grid_columns = ( isset( $wtnAttr['column'] ) ? $wtnAttr['column'] : $wtn_int_grid_columns );
$wtn_order_by = ( isset( $wtnAttr['order_by'] ) ? $wtnAttr['order_by'] : $wtn_int_news_sorting );
$wtn_order = ( isset( $wtnAttr['order'] ) ? $wtnAttr['order'] : $wtn_int_news_order );
$wtn_news_number = ( isset( $wtnAttr['display'] ) ? $wtnAttr['display'] : $wtn_int_news_number );
$wtn_int_title_length = ( isset( $wtnAttr['title_length'] ) ? $wtnAttr['title_length'] : $wtn_int_title_length );
$wtn_desc_length = ( isset( $wtnAttr['desc_length'] ) ? $wtnAttr['desc_length'] : $wtn_int_desc_length );
$wtn_pagination = ( isset( $wtnAttr['pagination'] ) ? $wtnAttr['pagination'] : $wtn_display_pagination );

if ( is_front_page() ) {
    $page = ( get_query_var( 'page' ) ? get_query_var( 'page' ) : 1 );
} else {
    $page = ( get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1 );
}

// Main Query Arguments
$newsArr = array(
    'post_type'      => 'wtn_news',
    'post_status'    => 'publish',
    'orderby'        => $wtn_order_by,
    'order'          => $wtn_order,
    'posts_per_page' => $wtn_news_number,
    'meta_query'     => array( array(
    'key'     => 'wtn_status',
    'value'   => 'active',
    'compare' => '=',
) ),
);
if ( $wtn_pagination ) {
    $newsArr['paged'] = $page;
}
if ( '' !== $wtn_category ) {
    $newsArr['tax_query'] = array( array(
        'taxonomy' => 'news_category',
        'field'    => 'name',
        'terms'    => $wtn_category,
    ) );
}
$newsArr = apply_filters( 'wtn_news_front_main_query_array', $newsArr );
$wtnNews = new WP_Query( $newsArr );
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
if ( $wtn_int_enable_rtl ) {
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

if ( $wtnNews->have_posts() ) {
    ?>
    <div class="wtn-main-wrapper <?php 
    esc_attr_e( $wtn_layout );
    ?>">
        <?php 
    while ( $wtnNews->have_posts() ) {
        $wtnNews->the_post();
        $wtnCategories = wp_get_post_terms( $post->ID, 'news_category', array(
            'fields' => 'all',
        ) );
        $wtnImg = WTN_ASSETS . 'img/noimage.jpg';
        if ( has_post_thumbnail() ) {
            $wtnImg = get_the_post_thumbnail_url( $post->ID, 'full' );
        }
        $wtn_title = esc_html( wp_trim_words( get_the_title(), $wtn_int_title_length ) );
        $wtn_description = esc_html( wp_trim_words( get_the_content(), $wtn_desc_length ) );
        if ( 'list' === $wtn_layout ) {
            include 'temp/list.php';
        }
        if ( 'grid' === $wtn_layout ) {
            include 'temp/grid.php';
        }
    }
    ?>
    </div>
    <?php 
    
    if ( $wtn_pagination ) {
        ?>
        <div class="wtn-pagination">
            <?php 
        
        if ( $wtnNews->max_num_pages > 1 ) {
            $wbgPaginateBig = 999999999;
            // need an unlikely integer
            $wbgPaginateArgs = array(
                'base'      => str_replace( $wbgPaginateBig, '%#%', esc_url( get_pagenum_link( $wbgPaginateBig ) ) ),
                'format'    => '?page=%#%',
                'total'     => $wtnNews->max_num_pages,
                'current'   => max( 1, $page ),
                'end_size'  => 1,
                'mid_size'  => 2,
                'prev_text' => __( '« ' ),
                'next_text' => __( ' »' ),
                'type'      => 'list',
            );
            echo  paginate_links( $wbgPaginateArgs ) ;
        }
        
        ?>
        </div>
        <?php 
    }
    
    wp_reset_postdata();
} else {
    _e( 'No News Available', 'wp-top-news' );
}
