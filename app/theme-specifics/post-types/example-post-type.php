<?php

// Register Example
function example_post_type($textDomain) {

	$labels = array(
		'name'                  => _x( 'Example Posts', 'Post Type General Name', $textDomain ),
		'singular_name'         => _x( 'Example Post', 'Post Type Singular Name', $textDomain ),
		'menu_name'             => __( 'Example Posts', $textDomain ),
		'name_admin_bar'        => __( 'Example Post', $textDomain ),
		'archives'              => __( 'Example Post Archives', $textDomain ),
		'attributes'            => __( 'Example Post Attributes', $textDomain ),
		'parent_item_colon'     => __( 'Parent Example Post:', $textDomain ),
		'all_items'             => __( 'All Example Posts', $textDomain ),
		'add_new_item'          => __( 'Add New Example Post', $textDomain ),
		'add_new'               => __( 'Add New', $textDomain ),
		'new_item'              => __( 'New Example Post', $textDomain ),
		'edit_item'             => __( 'Edit Example Post', $textDomain ),
		'update_item'           => __( 'Update Example Post', $textDomain ),
		'view_item'             => __( 'View Example Post', $textDomain ),
		'view_items'            => __( 'View Example Posts', $textDomain ),
		'search_items'          => __( 'Search Example Post', $textDomain ),
		'not_found'             => __( 'Not found', $textDomain ),
		'not_found_in_trash'    => __( 'Not found in Trash', $textDomain ),
		'featured_image'        => __( 'Featured Image', $textDomain ),
		'set_featured_image'    => __( 'Set featured image', $textDomain ),
		'remove_featured_image' => __( 'Remove featured image', $textDomain ),
		'use_featured_image'    => __( 'Use as featured image', $textDomain ),
		'insert_into_item'      => __( 'Insert into Example Post', $textDomain ),
		'uploaded_to_this_item' => __( 'Uploaded to this Example Post', $textDomain ),
		'items_list'            => __( 'Examples list', $textDomain ),
		'items_list_navigation' => __( 'Examples list navigation', $textDomain ),
		'filter_items_list'     => __( 'Filter Example Posts list', $textDomain ),
	);
	$args = array(
		'label'                 => __( 'Example Post', $textDomain ),
		'description'           => __( 'Example Post Type', $textDomain ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'custom-fields', 'editor', 'revisions', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'menu_icon'             => 'dashicons-welcome-write-blog',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'example_pt', $args );

}
add_action( 'init', 'example_post_type', 0 );
