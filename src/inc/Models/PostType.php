<?php # -*- coding: utf-8 -*-

namespace tfrommen\ExternalContent\Models;

/**
 * Post type model.
 *
 * @package tfrommen\ExternalContent\Models
 */
class PostType {

	/**
	 * @var string
	 */
	private $post_type;

	/**
	 * Constructor. Set up the properties.
	 */
	public function __construct() {

		/**
		 * Filter the post type.
		 *
		 * @param string $post_type Post type.
		 */
		$this->post_type = apply_filters( 'external_content_post_type', 'external_content' );
	}

	/**
	 * Return the post type slug.
	 *
	 * @return string
	 */
	public function get_post_type() {

		return $this->post_type;
	}

	/**
	 * Register the post type.
	 *
	 * @wp-hook wp_loaded
	 *
	 * @return void
	 */
	public function register() {

		$labels = array(
			'name'               => _x( 'External Content', 'Post type general name', 'external-content' ),
			'singular_name'      => _x( 'External Content', 'Post type singular name', 'external-content' ),
			'menu_name'          => _x( 'External Content', 'Post type menu name', 'external-content' ),
			'name_admin_bar'     => _x( 'External Content', 'Post type admin bar name', 'external-content' ),
			'all_items'          => __( 'All External Content', 'external-content' ),
			'add_new'            => _x( 'Add New', 'Add new post', 'external-content' ),
			'add_new_item'       => __( 'Add New External Content', 'external-content' ),
			'edit_item'          => __( 'Edit External Content', 'external-content' ),
			'new_item'           => __( 'New External Content', 'external-content' ),
			'view_item'          => __( 'View External Content', 'external-content' ),
			'search_items'       => __( 'Search External Content', 'external-content' ),
			'not_found'          => __( 'No External Content found.', 'external-content' ),
			'not_found_in_trash' => __( 'No External Content found in Trash.', 'external-content' ),
			'parent_item_colon'  => __( 'Parent External Content:', 'external-content' ),
		);
		/**
		 * Filter the post type labels.
		 *
		 * @param array $labels Post type labels.
		 */
		$labels = apply_filters( 'external_content_labels', $labels );

		$supports = array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
		);
		/**
		 * Filter the post type supports.
		 *
		 * @param array $supports Post type supports.
		 */
		$supports = apply_filters( 'external_content_supports', $supports );

		$description = apply_filters( 'external_content_description', '' );

		$args = array(
			'labels'               => $labels,
			'description'          => $description,
			'public'               => TRUE,
			'hierarchical'         => FALSE,
			'exclude_from_search'  => TRUE,
			'publicly_queryable'   => FALSE,
			'show_ui'              => TRUE,
			'show_in_nav_menus'    => FALSE,
			'menu_icon'            => 'dashicons-external',
			'supports'             => $supports,
			'register_meta_box_cb' => array( $this, 'customize_meta_boxes' ),
			'rewrite'              => FALSE,
		);
		/**
		 * Filter the post type args.
		 *
		 * @param array $args Post type args.
		 */
		$args = apply_filters( 'external_content_args', $args );

		register_post_type( $this->post_type, $args );
	}

	/**
	 * Remove the Slug meta box.
	 *
	 * @return void
	 */
	public function customize_meta_boxes() {

		remove_meta_box( 'slugdiv', '', 'normal' );
	}

}
