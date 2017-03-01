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

// add tags and categories to github
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


// github tags and categories to post
add_filter('wpghs_pre_import_args', function ($args, $wpghs_post) {

    $meta = $wpghs_post->get_meta();
    echo "meta start\n";
    var_dump($meta);
    echo "meta end\n";
    if (!empty($meta['tags'])) {
        $args['tags_input'] = $meta['tags'];
    }
    // if (!empty($meta['categories'])) {
    //     $args['post_category'] = $meta['categories'];
    // }

    return $args;
}, 10, 2);


// github meta to post
add_filter('wpghs_pre_import_meta', function ($meta, $wpghs_post) {
    unset($meta['tags']);
    unset($meta['categories']);

    // unset wordpress github sync meta
    unset($meta['author']);
    unset($meta['post_date']);
    unset($meta['post_excerpt']);
    unset($meta['permalink']);
    return $meta;
}, 10, 2);

