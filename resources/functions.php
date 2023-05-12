<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 *
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$sage_error = function ( $message, $subtitle = '', $title = '' ) {

	$title   = $title ? : __( 'Sage &rsaquo; Error', 'sage' );
	$footer  = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
	$message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
	wp_die( $message, $title );
};

/**
 * Ensure compatible version of PHP is used
 */
if ( version_compare( '7.1', phpversion(), '>=' ) ) {
	$sage_error( __( 'You must be using PHP 7.1 or greater.', 'sage' ), __( 'Invalid PHP version', 'sage' ) );
}

/**
 * Ensure compatible version of WordPress is used
 */
if ( version_compare( '4.7.0', get_bloginfo( 'version' ), '>=' ) ) {
	$sage_error( __( 'You must be using WordPress 4.7.0 or greater.', 'sage' ), __( 'Invalid WordPress version', 'sage' ) );
}

/**
 * Ensure dependencies are loaded
 */
if ( ! class_exists( 'Roots\\Sage\\Container' ) ) {
	if ( ! file_exists( $composer = __DIR__ . '/../vendor/autoload.php' ) ) {
		$sage_error(
			__( 'You must run <code>composer install</code> from the Sage directory.', 'sage' ),
			__( 'Autoloader not found.', 'sage' )
		);
	}
	require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map( function ( $file ) use ( $sage_error ) {

	$file = "../app/{$file}.php";
	if ( ! locate_template( $file, true, true ) ) {
		$sage_error( sprintf( __( 'Error locating <code>%s</code> for inclusion.', 'sage' ), $file ), 'File not found' );
	}
}, [ 'helpers', 'setup', 'filters', 'admin', 'blocks', 'theme-specifics' ] );

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
	'add_filter',
	[ 'theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri' ],
	array_fill( 0, 4, 'dirname' )
);
Container::getInstance()
         ->bindIf( 'config', function () {

	         return new Config( [
		         'assets' => require dirname( __DIR__ ) . '/config/assets.php',
		         'theme'  => require dirname( __DIR__ ) . '/config/theme.php',
		         'view'   => require dirname( __DIR__ ) . '/config/view.php',
	         ] );
         }, true );

/** Custom Additions */

// Remove Yoast from post types as needed

// function my_remove_wp_seo_meta_box() {

// 	remove_meta_box( 'wpseo_meta', 'POST_TYPE_NAME', 'normal' );
// }

// add_action( 'add_meta_boxes', 'my_remove_wp_seo_meta_box', 100 );

/*
* Function for post duplication. Dups appear as drafts. User is redirected to the edit screen
*/
function rd_duplicate_post_as_draft() {

	global $wpdb;
	if ( ! ( isset( $_GET['post'] ) || isset( $_POST['post'] ) || ( isset( $_REQUEST['action'] ) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
		wp_die( 'No post to duplicate has been supplied!' );
	}
	/*
	 * Nonce verification
	 */
	if ( ! isset( $_GET['duplicate_nonce'] ) || ! wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	/*
	 * get the original post id
	 */
	$post_id = ( isset( $_GET['post'] ) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
	/*
	 * and all the original post data then
	 */
	$post = get_post( $post_id );
	/*
	 * if you don't want current user to be the new post author,
	 * then change next couple of lines to this: $new_post_author = $post->post_author;
	 */
	$current_user    = wp_get_current_user();
	$new_post_author = $current_user->ID;
	/*
	 * if post data exists, create the post duplicate
	 */
	if ( isset( $post ) && $post != null ) {
		/*
		 * new post data array
		 */
		$args = [
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order,
		];
		/*
		 * insert the post by wp_insert_post() function
		 */
		$new_post_id = wp_insert_post( $args );
		/*
		 * get all current post terms ad set them to the new post draft
		 */
		$taxonomies = get_object_taxonomies( $post->post_type ); // returns array of taxonomy names for post type, ex array("category", "post_tag");
		foreach ( $taxonomies as $taxonomy ) {
			$post_terms = wp_get_object_terms( $post_id, $taxonomy, [ 'fields' => 'slugs' ] );
			wp_set_object_terms( $new_post_id, $post_terms, $taxonomy, false );
		}
		/*
		 * duplicate all post meta just in two SQL queries
		 */
		$post_meta_infos = $wpdb->get_results( "SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id" );
		if ( count( $post_meta_infos ) != 0 ) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ( $post_meta_infos as $meta_info ) {
				$meta_key = $meta_info->meta_key;
				if ( $meta_key == '_wp_old_slug' ) {
					continue;
				}
				$meta_value      = addslashes( $meta_info->meta_value );
				$sql_query_sel[] = "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query .= implode( " UNION ALL ", $sql_query_sel );
			$wpdb->query( $sql_query );
		}
		/*
		 * finally, redirect to the edit post screen for the new draft
		 */
		wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		exit;
	} else {
		wp_die( 'Post creation failed, could not find original post: ' . $post_id );
	}
}

add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );
/*
 * Add the duplicate link to action list for post_row_actions
 */
function rd_duplicate_post_link( $actions, $post ) {

	if ( current_user_can( 'edit_posts' ) ) {
		$actions['duplicate'] = '<a href="' . wp_nonce_url( 'admin.php?action=rd_duplicate_post_as_draft&post=' . $post->ID, basename( __FILE__ ), 'duplicate_nonce' ) . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
	}

	return $actions;
}

add_filter( 'post_row_actions', 'rd_duplicate_post_link', 10, 2 );

/*
 * Function for page duplication. Dups appear as drafts. User is redirected to the edit screen
 */
function rd_duplicate_page_as_draft() {

	global $wpdb;
	if ( ! ( isset( $_GET['post'] ) || isset( $_POST['post'] ) || ( isset( $_REQUEST['action'] ) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
		wp_die( 'No post to duplicate has been supplied!' );
	}
	/*
	 * Nonce verification
	 */
	if ( ! isset( $_GET['duplicate_nonce'] ) || ! wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	/*
	 * get the original post id
	 */
	$post_id = ( isset( $_GET['post'] ) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
	/*
	 * and all the original post data then
	 */
	$post = get_post( $post_id );
	/*
	 * if you don't want current user to be the new post author,
	 * then change next couple of lines to this: $new_post_author = $post->post_author;
	 */
	$current_user    = wp_get_current_user();
	$new_post_author = $current_user->ID;
	/*
	 * if post data exists, create the post duplicate
	 */
	if ( isset( $post ) && $post != null ) {
		/*
		 * new post data array
		 */
		$args = [
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order,
		];
		/*
		 * insert the post by wp_insert_post() function
		 */
		$new_post_id = wp_insert_post( $args );
		/*
		 * get all current post terms ad set them to the new post draft
		 */
		$taxonomies = get_object_taxonomies( $post->post_type ); // returns array of taxonomy names for post type, ex array("category", "post_tag");
		foreach ( $taxonomies as $taxonomy ) {
			$post_terms = wp_get_object_terms( $post_id, $taxonomy, [ 'fields' => 'slugs' ] );
			wp_set_object_terms( $new_post_id, $post_terms, $taxonomy, false );
		}
		/*
		 * duplicate all post meta just in two SQL queries
		 */
		$post_meta_infos = $wpdb->get_results( "SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id" );
		if ( count( $post_meta_infos ) != 0 ) {
			$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
			foreach ( $post_meta_infos as $meta_info ) {
				$meta_key = $meta_info->meta_key;
				if ( $meta_key == '_wp_old_slug' ) {
					continue;
				}
				$meta_value      = addslashes( $meta_info->meta_value );
				$sql_query_sel[] = "SELECT $new_post_id, '$meta_key', '$meta_value'";
			}
			$sql_query .= implode( " UNION ALL ", $sql_query_sel );
			$wpdb->query( $sql_query );
		}
		/*
		 * finally, redirect to the edit post screen for the new draft
		 */
		wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
		exit;
	} else {
		wp_die( 'Post creation failed, could not find original post: ' . $post_id );
	}
}

add_action( 'admin_action_rd_duplicate_page_as_draft', 'rd_duplicate_page_as_draft' );
/*
 * Add the duplicate link to action list for post_row_actions
 */
function rd_duplicate_page_link( $actions, $post ) {

	if ( current_user_can( 'edit_posts' ) ) {
		$actions['duplicate'] = '<a href="' . wp_nonce_url( 'admin.php?action=rd_duplicate_post_as_draft&post=' . $post->ID, basename( __FILE__ ), 'duplicate_nonce' ) . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
	}

	return $actions;
}

add_filter( 'page_row_actions', 'rd_duplicate_page_link', 10, 2 );

/** End Custom Additions */
