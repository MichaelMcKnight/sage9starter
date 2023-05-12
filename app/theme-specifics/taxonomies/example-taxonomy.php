<?php
function example_taxonomy($textDomain) {

	$labels = array(
		'name'                       => _x( 'Example Taxx', 'Taxonomy General Name', $textDomain ),
		'singular_name'              => _x( 'Example Tax', 'Taxonomy Singular Name', $textDomain ),
		'menu_name'                  => __( 'Example Taxs', $textDomain ),
		'all_items'                  => __( 'All Example Taxs', $textDomain ),
		'parent_item'                => __( 'Parent Example Tax', $textDomain ),
		'parent_item_colon'          => __( 'Parent Example Tax:', $textDomain ),
		'new_item_name'              => __( 'New Example Tax Name', $textDomain ),
		'add_new_item'               => __( 'Add New Example Tax', $textDomain ),
		'edit_item'                  => __( 'Edit Example Tax', $textDomain ),
		'update_item'                => __( 'Update Example Tax', $textDomain ),
		'view_item'                  => __( 'View Example Tax', $textDomain ),
		'separate_items_with_commas' => __( 'Separate Example Taxs with commas', $textDomain ),
		'add_or_remove_items'        => __( 'Add or remove Example Taxs', $textDomain ),
		'choose_from_most_used'      => __( 'Choose from the most used', $textDomain ),
		'popular_items'              => __( 'Popular Example Taxs', $textDomain ),
		'search_items'               => __( 'Search Example Taxs', $textDomain ),
		'not_found'                  => __( 'Not Found', $textDomain ),
		'no_terms'                   => __( 'No Example Taxs', $textDomain ),
		'items_list'                 => __( 'Example Taxs list', $textDomain ),
		'items_list_navigation'      => __( 'Example Taxs list navigation', $textDomain ),
	);
	$rewrite = array(
		'slug'                       => 'example_pt/example_tax',
		'with_front'                 => false,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => $rewrite,
		'show_in_rest'               => true,
	);
	register_taxonomy( 'example_tax', array( 'example_pt' ), $args );

}
add_action( 'init', 'example_taxonomy', 0 );