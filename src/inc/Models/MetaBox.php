<?php # -*- coding: utf-8 -*-

namespace tfrommen\ExternalContent\Models;

use tfrommen\ExternalContent\Views;

/**
 * Meta box model.
 *
 * @package tfrommen\ExternalContent\Models
 */
class MetaBox {

	/**
	 * @var string
	 */
	private $meta_key;

	/**
	 * @var Nonce
	 */
	private $nonce;

	/**
	 * @var string
	 */
	private $post_type;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param PostType $post_type Post type model.
	 * @param Nonce    $nonce     Nonce model.
	 */
	public function __construct( PostType $post_type, Nonce $nonce ) {

		$this->post_type = $post_type->get_post_type();

		$this->nonce = $nonce;

		/**
		 * Filter the meta key.
		 *
		 * @param string $meta_key Meta key.
		 */
		$this->meta_key = (string) apply_filters( 'external_content_meta_key', '_external_content' );
		$this->meta_key = esc_attr( $this->meta_key );
	}

	/**
	 * Return the meta key.
	 *
	 * @return string
	 */
	public function get_meta_key() {

		return $this->meta_key;
	}

	/**
	 * Save the meta data.
	 *
	 * @wp-hook save_post
	 *
	 * @param int      $post_id Post ID.
	 * @param \WP_Post $post    Post object.
	 *
	 * @return bool
	 */
	public function save( $post_id, $post ) {

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return FALSE;
		}

		if ( wp_is_post_revision( $post_id ) ) {
			return FALSE;
		}

		if ( $post->post_type !== $this->post_type ) {
			return FALSE;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return FALSE;
		}

		if ( ! $this->nonce->is_valid() ) {
			return FALSE;
		}

		$meta_value = isset( $_POST[ $this->meta_key ] ) ? $_POST[ $this->meta_key ] : '';

		return (bool) update_post_meta( $post_id, $this->meta_key, $meta_value );
	}

}
