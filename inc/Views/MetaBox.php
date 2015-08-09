<?php # -*- coding: utf-8 -*-

namespace tf\ExternalContent\Views;

use tf\ExternalContent\Models\MetaBox as Model;
use tf\ExternalContent\Models\Nonce as NonceModel;
use tf\ExternalContent\Models\PostType as PostTypeModel;

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
	 * @var NonceModel
	 */
	private $nonce;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param Model         $model     Model.
	 * @param PostTypeModel $post_type Post type model.
	 * @param NonceModel    $nonce     Nonce model.
	 */
	public function __construct( Model $model, PostTypeModel $post_type, NonceModel $nonce ) {

		$this->meta_key = $model->get_meta_key();

		$this->post_type = $post_type->get_post_type();

		$this->nonce = $nonce;
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
			esc_html__( 'URL', 'external-content' ),
			array( $this, 'render' ),
			$post_type,
			'advanced',
			'high'
		);
	}

	/**
	 * Render the HTML.
	 *
	 * @param \WP_Post $post Post object.
	 *
	 * @return void
	 */
	public function render( \WP_Post $post ) {

		$meta_value = get_post_meta( $post->ID, $this->meta_key, TRUE );

		$this->nonce->print_field();
		?>
		<p>
			<?php esc_html_e( 'Please enter the URL of the external content.', 'external-content' ); ?>
		</p>
		<table class="form-table">
			<tbody>
			<tr>
				<th scope="row">
					<label for="<?php echo $this->meta_key; ?>">
						<?php esc_html_e( 'External URL', 'external-content' ); ?>
					</label>
				</th>
				<td>
					<input type="url" name="<?php echo $this->meta_key; ?>" class="large-text"
						placeholder="http://example.com" value="<?php echo esc_attr( $meta_value ); ?>">
				</td>
			</tr>
			</tbody>
		</table>
	<?php
	}

}
