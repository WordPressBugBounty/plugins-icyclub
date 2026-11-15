<?php
/**
 * Gutenberg-Native Portfolio Custom Post Type & Taxonomies
 *
 * Registered as a universal feature for all icyclub users.
 * Post Type: icyclub_portfolio (with backward-compatible support for legacy consultup_portfolio)
 * Taxonomy: portfolio_categories
 * Post Meta Keys: port_cpt_link, port_cpt_target, port_disc
 *
 * @package Icyclub
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Register Custom Post Type with Gutenberg & REST API support
 */
function icycp_register_portfolio_cpt() {
	$labels = array(
		'name'                  => _x( 'Portfolio', 'Post Type General Name', 'icyclub' ),
		'singular_name'         => _x( 'Portfolio', 'Post Type Singular Name', 'icyclub' ),
		'menu_name'             => __( 'Portfolio', 'icyclub' ),
		'name_admin_bar'        => __( 'Portfolio', 'icyclub' ),
		'archives'              => __( 'Portfolio Archives', 'icyclub' ),
		'attributes'            => __( 'Portfolio Attributes', 'icyclub' ),
		'parent_item_colon'     => __( 'Parent Portfolio:', 'icyclub' ),
		'all_items'             => __( 'All Portfolio', 'icyclub' ),
		'add_new_item'          => __( 'Add New Portfolio', 'icyclub' ),
		'add_new'               => __( 'Add New', 'icyclub' ),
		'new_item'              => __( 'New Portfolio', 'icyclub' ),
		'edit_item'             => __( 'Edit Portfolio', 'icyclub' ),
		'update_item'           => __( 'Update Portfolio', 'icyclub' ),
		'view_item'             => __( 'View Portfolio', 'icyclub' ),
		'view_items'            => __( 'View Portfolio', 'icyclub' ),
		'search_items'          => __( 'Search Portfolio', 'icyclub' ),
		'not_found'             => __( 'No portfolio items found', 'icyclub' ),
		'not_found_in_trash'    => __( 'No portfolio items found in Trash', 'icyclub' ),
		'featured_image'        => __( 'Portfolio Image', 'icyclub' ),
		'set_featured_image'    => __( 'Set portfolio image', 'icyclub' ),
		'remove_featured_image' => __( 'Remove portfolio image', 'icyclub' ),
		'use_featured_image'    => __( 'Use as portfolio image', 'icyclub' ),
		'insert_into_item'      => __( 'Insert into portfolio', 'icyclub' ),
		'uploaded_to_this_item' => __( 'Uploaded to this portfolio', 'icyclub' ),
		'items_list'            => __( 'Portfolio list', 'icyclub' ),
		'items_list_navigation' => __( 'Portfolio list navigation', 'icyclub' ),
		'filter_items_list'     => __( 'Filter portfolio list', 'icyclub' ),
	);

	$args = array(
		'label'               => __( 'Portfolio', 'icyclub' ),
		'description'         => __( 'Portfolio Custom Post Type', 'icyclub' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 11,
		'menu_icon'           => 'dashicons-portfolio',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'show_in_rest'        => true, // Pure Gutenberg activation
		'rewrite'             => array(
			'slug'       => 'portfolio',
			'with_front' => false,
		),
	);

	register_post_type( 'icyclub_portfolio', $args );
}
add_action( 'init', 'icycp_register_portfolio_cpt', 5 );

/**
 * 2. Register Custom Taxonomy with Gutenberg & REST API support
 */
function icycp_register_portfolio_taxonomy() {
	$portfolio_prefix   = apply_filters( 'icycp_portfolio_category_label', __( 'Portfolio Categories', 'icyclub' ) );
	$portfolio_category = apply_filters( 'icycp_portfolio_category_slug', 'portfolio_category' );

	$labels = array(
		'name'                       => _x( 'Portfolio Categories', 'Taxonomy General Name', 'icyclub' ),
		'singular_name'              => _x( 'Portfolio Category', 'Taxonomy Singular Name', 'icyclub' ),
		'menu_name'                  => __( 'Categories', 'icyclub' ),
		'all_items'                  => __( 'All Categories', 'icyclub' ),
		'parent_item'                => __( 'Parent Category', 'icyclub' ),
		'parent_item_colon'          => __( 'Parent Category:', 'icyclub' ),
		'new_item_name'              => __( 'New Category Name', 'icyclub' ),
		'add_new_item'               => __( 'Add New Category', 'icyclub' ),
		'edit_item'                  => __( 'Edit Category', 'icyclub' ),
		'update_item'                => __( 'Update Category', 'icyclub' ),
		'view_item'                  => __( 'View Category', 'icyclub' ),
		'separate_items_with_commas' => __( 'Separate categories with commas', 'icyclub' ),
		'add_or_remove_items'        => __( 'Add or remove categories', 'icyclub' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'icyclub' ),
		'popular_items'              => __( 'Popular Categories', 'icyclub' ),
		'search_items'               => __( 'Search Categories', 'icyclub' ),
		'not_found'                  => __( 'Not Found', 'icyclub' ),
		'no_terms'                   => __( 'No categories', 'icyclub' ),
		'items_list'                 => __( 'Categories list', 'icyclub' ),
		'items_list_navigation'      => __( 'Categories list navigation', 'icyclub' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => true,
		'show_in_rest'      => true, // Pure Gutenberg native category selector in sidebar
		'rewrite'           => array(
			'slug'         => $portfolio_category,
			'hierarchical' => true,
		),
		'query_var'         => true,
	);

	// Register for both icyclub_portfolio and consultup_portfolio (for backward compatibility)
	register_taxonomy( 'portfolio_categories', array( 'icyclub_portfolio', 'consultup_portfolio' ), $args );
}
add_action( 'init', 'icycp_register_portfolio_taxonomy', 5 );

/**
 * 3. Register Post Meta into REST API for Gutenberg Native Storage
 *
 * Supported post types:
 * - icyclub_portfolio
 * - consultup_portfolio
 *
 * Exact same keys as Consultup Pro:
 * - port_cpt_link: Link URL
 * - port_cpt_target: Open in new tab ('1' or '')
 * - port_disc: Portfolio short description
 */
function icycp_register_portfolio_post_meta() {
	$auth_cb = function() {
		return current_user_can( 'edit_posts' );
	};

	$post_types = array( 'icyclub_portfolio', 'consultup_portfolio' );

	foreach ( $post_types as $cpt ) {
		// 1) Target Link URL
		register_post_meta( $cpt, 'port_cpt_link', array(
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'string',
			'sanitize_callback' => 'esc_url_raw',
			'auth_callback'     => $auth_cb,
		) );

		// 2) Open in new tab ('1' / 'on' / '')
		register_post_meta( $cpt, 'port_cpt_target', array(
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback'     => $auth_cb,
		) );

		// 3) Description
		register_post_meta( $cpt, 'port_disc', array(
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_textarea_field',
			'auth_callback'     => $auth_cb,
		) );
	}
}
add_action( 'init', 'icycp_register_portfolio_post_meta', 10 );

/**
 * 4. Enqueue Gutenberg Editor Assets (Native Inspector Panel)
 */
function icycp_enqueue_portfolio_editor_assets() {
	$current_screen = get_current_screen();
	if ( ! $current_screen || ! in_array( $current_screen->post_type, array( 'icyclub_portfolio', 'consultup_portfolio' ), true ) ) {
		return;
	}

	$script_path = ICYCP_PLUGIN_DIR . 'assets/js/portfolio-sidebar.js';
	$script_url  = ICYCP_PLUGIN_URL . 'assets/js/portfolio-sidebar.js';

	$version = file_exists( $script_path ) ? filemtime( $script_path ) : '1.0.0';

	wp_enqueue_script(
		'icycp-portfolio-sidebar',
		$script_url,
		array( 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data', 'wp-core-data', 'wp-i18n' ),
		$version,
		true
	);

	if ( function_exists( 'wp_set_script_translations' ) ) {
		wp_set_script_translations( 'icycp-portfolio-sidebar', 'icyclub' );
	}
}
add_action( 'enqueue_block_editor_assets', 'icycp_enqueue_portfolio_editor_assets' );

/**
 * 5. Clean up duplicate legacy classic metaboxes if Consultup Pro theme is active
 */
function icycp_remove_legacy_portfolio_metabox() {
	remove_meta_box( 'portfolio_meta', 'consultup_portfolio', 'normal' );
	remove_meta_box( 'portfolio_meta', 'icyclub_portfolio', 'normal' );
}
add_action( 'add_meta_boxes', 'icycp_remove_legacy_portfolio_metabox', 99 );

/**
 * 6. Seamless Data Migration: Migrate legacy 'consultup_portfolio' posts to 'icyclub_portfolio'
 *
 * Runs safely once on admin_init. If existing posts exist with 'consultup_portfolio',
 * their post_type is updated to 'icyclub_portfolio' so zero data is lost.
 */
function icycp_migrate_legacy_portfolio_posts() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( get_option( 'icycp_portfolio_posts_migrated' ) ) {
		return;
	}

	global $wpdb;

	$has_legacy = $wpdb->get_var( "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'consultup_portfolio' LIMIT 1" );

	if ( $has_legacy ) {
		$wpdb->query( "UPDATE {$wpdb->posts} SET post_type = 'icyclub_portfolio' WHERE post_type = 'consultup_portfolio'" );
	}

	update_option( 'icycp_portfolio_posts_migrated', '1' );
}
add_action( 'admin_init', 'icycp_migrate_legacy_portfolio_posts' );

/**
 * 7. Query Fallback Compatibility:
 *
 * If any legacy theme template (e.g. consultup-pro homepage or content-portfolio.php)
 * queries 'post_type' => 'consultup_portfolio', automatically query 'icyclub_portfolio' as well.
 */
function icycp_portfolio_query_compat( $query ) {
	if ( is_admin() ) {
		return;
	}

	$post_type = $query->get( 'post_type' );

	if ( 'consultup_portfolio' === $post_type ) {
		$query->set( 'post_type', array( 'icyclub_portfolio', 'consultup_portfolio' ) );
	}
}
add_action( 'pre_get_posts', 'icycp_portfolio_query_compat' );

/**
 * 8. Auto-import Consultup Lite Customizer Portfolio Data into 'icyclub_portfolio' CPT
 *
 * Imports the Project/Portfolio Settings from the Customizer:
 * - project_title_one, project_desc_one, project_image_one
 * - project_title_two, project_desc_two, project_image_two
 * - project_title_three, project_desc_three, project_image_three
 *
 * Runs on admin_init if no posts exist in icyclub_portfolio, or when reimport is requested.
 */
function icycp_auto_import_lite_portfolio_data() {
	if ( ! current_user_can( 'edit_posts' ) ) {
		return;
	}

	$force_import = isset( $_GET['icycp_reimport_portfolio'] ) && check_admin_referer( 'icycp_reimport_portfolio_nonce' );

	if ( ! $force_import && get_option( 'icycp_lite_portfolio_imported' ) ) {
		return;
	}

	// Check if any portfolio posts already exist
	if ( ! $force_import ) {
		$existing_posts = get_posts( array(
			'post_type'      => array( 'icyclub_portfolio', 'consultup_portfolio' ),
			'posts_per_page' => 1,
			'post_status'    => 'any',
			'fields'         => 'ids',
		) );

		if ( ! empty( $existing_posts ) ) {
			update_option( 'icycp_lite_portfolio_imported', '1' );
			return;
		}
	}

	// Ensure required files for media upload are available
	if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
	}

	$portfolio_items = array(
		array(
			'title'       => get_theme_mod( 'project_title_one', __( 'Financial Project', 'icyclub' ) ),
			'desc'        => get_theme_mod( 'project_desc_one', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit..' ),
			'image'       => get_theme_mod( 'project_image_one', ICYCP_PLUGIN_URL . 'inc/consultup/images/portfolio/portfolio1.jpg' ),
			'local_image' => ICYCP_PLUGIN_DIR . 'inc/consultup/images/portfolio/portfolio1.jpg',
		),
		array(
			'title'       => get_theme_mod( 'project_title_two', __( 'Investment', 'icyclub' ) ),
			'desc'        => get_theme_mod( 'project_desc_two', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit..' ),
			'image'       => get_theme_mod( 'project_image_two', ICYCP_PLUGIN_URL . 'inc/consultup/images/portfolio/portfolio2.jpg' ),
			'local_image' => ICYCP_PLUGIN_DIR . 'inc/consultup/images/portfolio/portfolio2.jpg',
		),
		array(
			'title'       => get_theme_mod( 'project_title_three', __( 'Invoicing', 'icyclub' ) ),
			'desc'        => get_theme_mod( 'project_desc_three', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit..' ),
			'image'       => get_theme_mod( 'project_image_three', ICYCP_PLUGIN_URL . 'inc/consultup/images/portfolio/portfolio3.jpg' ),
			'local_image' => ICYCP_PLUGIN_DIR . 'inc/consultup/images/portfolio/portfolio3.jpg',
		),
	);

	// Ensure default portfolio category exists
	$cat_id = null;
	$term   = term_exists( 'Portfolio', 'portfolio_categories' );
	if ( ! $term ) {
		$term = wp_insert_term( 'Portfolio', 'portfolio_categories' );
	}
	if ( ! is_wp_error( $term ) && isset( $term['term_id'] ) ) {
		$cat_id = (int) $term['term_id'];
	}

	foreach ( $portfolio_items as $item ) {
		$title = sanitize_text_field( $item['title'] );
		$desc  = sanitize_textarea_field( $item['desc'] );

		if ( empty( $title ) ) {
			continue;
		}

		// Avoid duplicate posts by title
		$existing_query = new WP_Query( array(
			'post_type'              => 'icyclub_portfolio',
			'title'                  => $title,
			'post_status'            => 'all',
			'posts_per_page'         => 1,
			'no_found_rows'          => true,
			'ignore_sticky_posts'    => true,
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'fields'                 => 'ids',
		) );
		if ( ! empty( $existing_query->posts ) ) {
			continue;
		}

		// Gutenberg-native content
		$content = '<!-- wp:paragraph -->' . "\n" . '<p>' . esc_html( $desc ) . '</p>' . "\n" . '<!-- /wp:paragraph -->';

		$post_id = wp_insert_post( array(
			'post_title'   => $title,
			'post_content' => $content,
			'post_excerpt' => $desc,
			'post_status'  => 'publish',
			'post_type'    => 'icyclub_portfolio',
			'post_author'  => get_current_user_id() ? get_current_user_id() : 1,
		) );

		if ( $post_id && ! is_wp_error( $post_id ) ) {
			// Save meta fields (Consultup Pro & Gutenberg compatible)
			update_post_meta( $post_id, 'port_disc', $desc );
			update_post_meta( $post_id, 'port_cpt_link', '' );
			update_post_meta( $post_id, 'port_cpt_target', '' );

			// Assign category
			if ( $cat_id ) {
				wp_set_object_terms( $post_id, array( $cat_id ), 'portfolio_categories' );
			}

			// Set Featured Image
			icycp_set_portfolio_featured_image( $post_id, $item['image'], $item['local_image'] );
		}
	}

	update_option( 'icycp_lite_portfolio_imported', '1' );
}
add_action( 'admin_init', 'icycp_auto_import_lite_portfolio_data' );

/**
 * 9. Helper: Attach image from URL or bundled plugin asset as Featured Image
 */
function icycp_set_portfolio_featured_image( $post_id, $image_url, $local_fallback = '' ) {
	$attachment_id = 0;

	// Check if URL is an existing attachment
	if ( ! empty( $image_url ) ) {
		$attachment_id = attachment_url_to_postid( $image_url );
	}

	// If not found in media library, import from local bundled asset if available
	if ( ! $attachment_id && ! empty( $local_fallback ) && file_exists( $local_fallback ) ) {
		$filename  = basename( $local_fallback );
		$file_bits = file_get_contents( $local_fallback );

		if ( false !== $file_bits ) {
			$upload = wp_upload_bits( $filename, null, $file_bits );

			if ( empty( $upload['error'] ) ) {
				$wp_filetype = wp_check_filetype( $filename, null );
				$attachment  = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_title'     => sanitize_file_name( pathinfo( $filename, PATHINFO_FILENAME ) ),
					'post_content'   => '',
					'post_status'    => 'inherit',
				);

				$attachment_id = wp_insert_attachment( $attachment, $upload['file'], $post_id );

				if ( $attachment_id && ! is_wp_error( $attachment_id ) ) {
					$attach_data = wp_generate_attachment_metadata( $attachment_id, $upload['file'] );
					wp_update_attachment_metadata( $attachment_id, $attach_data );
				}
			}
		}
	}

	if ( $attachment_id && ! is_wp_error( $attachment_id ) ) {
		set_post_thumbnail( $post_id, $attachment_id );
	}
}
