<?php # -*- coding: utf-8 -*-

namespace tf\ExternalContent\Model;

use tf\ExternalContent\Model\PostType as Model;
use tf\ExternalContent\View;

/**
 * Class MetaBox
 *
 * @package tf\ExternalContent\View
 */
class MetaBox {

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
	 * @param Model $model Model.
	 */
	public function __construct( Model $model ) {

		/**
		 * Customize the meta key.
		 *
		 * @param string $meta_key Meta key.
		 */
		$this->meta_key = (string) apply_filters( 'external_content_meta_key', '_external_content' );
		$this->meta_key = esc_attr( $this->meta_key );

		$this->nonce = new Nonce( 'external_content_url' );

		$this->post_type = $model->get_post_type();
	}

	/**
	 * Add the meta box to the according post types.
	 *
	 * @wp-hook add_meta_boxes
	 *
	 * @param string $post_type Post type slug.
	 *
	 * @return void
	 */
	public function add( $post_type ) {

		if ( $post_type !== $this->post_type ) {
			return;
		}

		add_meta_box(
			'external_content_url',
			__( 'URL', 'external-content' ),
			array( new View\MetaBox( $this, $this->nonce ), 'render' ),
			$post_type,
			'advanced',
			'high'
		);
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
	 * @return void
	 */
	public function save( $post_id, $post ) {

		if (
			( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			|| wp_is_post_revision( $post_id )
			|| $post->post_type !== $this->post_type
			|| ! current_user_can( 'edit_post', $post_id )
		) {
			return;
		}

		if ( ! $this->nonce->is_valid() ) {
			return;
		}

		$meta_value = filter_input( INPUT_POST, $this->meta_key );
		update_post_meta( $post_id, $this->meta_key, $meta_value );
	}

}
