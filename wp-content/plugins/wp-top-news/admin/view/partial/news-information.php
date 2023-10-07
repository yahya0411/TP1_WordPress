<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
global  $post ;
$wtn_status = get_post_meta( $post->ID, 'wtn_status', true );
$wtn_is_breaking = get_post_meta( $post->ID, 'wtn_is_breaking', true );
$wtn_is_hero = get_post_meta( $post->ID, 'wtn_is_hero', true );
$wtn_is_featured = get_post_meta( $post->ID, 'wtn_is_featured', true );
?>
<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="wtn_is_breaking"><?php 
_e( 'Breaking', 'wp-top-news' );
?>?</label>
        </th>
        <td>
            <?php 
?>
                <span><?php 
echo  '<a href="' . wtn_fs()->get_upgrade_url() . '">' . __( 'Upgrade Now', 'wp-top-news' ) . '</a>' ;
?></span>
                <?php 
?>
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label for="wtn_is_hero"><?php 
_e( 'Display In Hero', 'wp-top-news' );
?>?</label>
        </th>
        <td>
            <?php 
?>
                <span><?php 
echo  '<a href="' . wtn_fs()->get_upgrade_url() . '">' . __( 'Upgrade Now', 'wp-top-news' ) . '</a>' ;
?></span>
                <?php 
?>
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label for="wtn_is_featured"><?php 
_e( 'Is Featured', 'wp-top-news' );
?>?</label>
        </th>
        <td>
            <?php 
?>
                <span><?php 
echo  '<a href="' . wtn_fs()->get_upgrade_url() . '">' . __( 'Upgrade Now', 'wp-top-news' ) . '</a>' ;
?></span>
                <?php 
?>
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label><?php 
_e( 'Status', 'wp-top-news' );
?></label>
        </th>
        <td>
            <input type="radio" name="wtn_status" id="wtn_status_active" value="active" <?php 
echo  ( 'inactive' !== $wtn_status ? 'checked' : '' ) ;
?> >
            <label for="wtn_status_active"><span></span><?php 
_e( 'Active', 'wp-top-news' );
?></label>
            &nbsp;&nbsp;
            <input type="radio" name="wtn_status" id="wtn_status_inactive" value="inactive" <?php 
echo  ( 'inactive' === $wtn_status ? 'checked' : '' ) ;
?> >
            <label for="wtn_status_inactive"><span></span><?php 
_e( 'Inactive', 'wp-top-news' );
?></label>
        </td>
    </tr>
    </tbody>
</table>