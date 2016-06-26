<?php
/**
 * Plugin Name:  WP GitHub Sync Meta
 * Plugin URI:   https://github.com/lite3/wp-github-sync-meta
 * Description:  Adds support for custom post meta
 * Version:      1.0.0
 * Author:       lite3
 * Author URI:   https://www.litefeel.com/
 * License:      GPL2
 */

add_filter('wpghs_post_meta', function ($meta, $wpghs_post) {
    $tags = array();
    $list = wp_get_post_tags( $wpghs_post->post->ID );
    if ( ! empty($list)) {
        foreach ($list as $value) {
            $tags[] = $value->name;
        }
    }
    $meta['tags'] = $tags;

    $categories = array();
    $list = get_the_category( $wpghs_post->post->ID );
    if ( ! empty( $list ) ) {
        foreach( $list as $value ) {
            $categories[] = $value->name;
        }
    }
    $meta['categories'] = $categories;

    return $meta;
}, 10, 2);
