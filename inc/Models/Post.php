<?php # -*- coding: utf-8 -*-

namespace tf\ExternalContent\Models;

/**
 * Class Post
 *
 * @package tf\ExternalContent\Models
 */
class Post {

	/**
	 * @var string
	 */
	private $meta_key;

	/**
	 * @var string
	 */
	private $post_type;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param PostType $post_type Post type model.
	 * @param MetaBox  $meta_box  Meta box model.
	 */
	public function __construct( PostType $post_type, MetaBox $meta_box ) {

		$this->meta_key = $meta_box->get_meta_key();

		$this->post_type = $post_type->get_post_type();
	}

	/**
	 * Return the external URL instead of the actual permalink.
	 *
	 * @wp-hook post_type_link
	 *
	 * @param string   $post_link Current post permalink.
	 * @param \WP_Post $post      Post object.
	 *
	 * @return string
	 */
	public function get_external_url( $post_link, $post ) {

		if (
			! isset( $post->post_type )
			|| $post->post_type !== $this->post_type
		) {
			return $post_link;
		}

		/**
		 * Filter the usage of the external URL as permalink.
		 *
		 * @param bool $use_external_url Use the external URL as permalink?
		 */
		if ( ! apply_filters( 'external_content_use_external_url', TRUE ) ) {
			return $post_link;
		}

		return get_post_meta( $post->ID, $this->meta_key, TRUE ) ?: '';
	}

	/**
	 * Return an empty string in order to hide the shortlink button.
	 *
	 * @wp-hook pre_get_shortlink
	 *
	 * @param string|bool $return  Current return value.
	 * @param int         $post_id Post ID.
	 * @param string      $context Shortlink context.
	 *
	 * @return string|bool
	 */
	public function get_shortlink( $return, $post_id, $context ) {

		if ( $context !== 'post' ) {
			return $return;
		}

		$post = get_post( $post_id );
		if (
			! $post
			|| $post->post_type !== $this->post_type
		) {
			return $return;
		}

		return '';
	}

}
