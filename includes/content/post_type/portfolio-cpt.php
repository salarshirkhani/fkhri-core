<?php
if ( ! defined('ABSPATH') ) exit;

/**
 * CPT: Portfolio (Customer testimonials)
 */
add_action('init', function () {

  $labels = [
    'name'               => 'Portfolio',
    'singular_name'      => 'Portfolio Item',
    'add_new'            => 'Add New',
    'add_new_item'       => 'Add New Portfolio Item',
    'edit_item'          => 'Edit Portfolio Item',
    'new_item'           => 'New Portfolio Item',
    'view_item'          => 'View Portfolio Item',
    'search_items'       => 'Search Portfolio',
    'not_found'          => 'Not found',
    'not_found_in_trash' => 'Not found in trash',
    'menu_name'          => 'Portfolio',
  ];

  register_post_type('fkhri_portfolio', [
    'labels'             => $labels,
    'public'             => true,
    'has_archive'        => true,
    'rewrite'            => ['slug' => 'portfolio'],
    'menu_icon'          => 'dashicons-format-video',
    'supports'           => ['title', 'thumbnail'],
    'show_in_rest'       => true,
  ]);

});
