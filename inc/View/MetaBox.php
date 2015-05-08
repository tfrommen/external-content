<?php # -*- coding: utf-8 -*-

namespace tf\ExternalContent\View;

use tf\ExternalContent\Model\MetaBox as Model;
use tf\ExternalContent\Model\Nonce;

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
	 * @var Nonce
	 */
	private $nonce;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param Model $model Model.
	 * @param Nonce $nonce Nonce object.
	 */
	public function __construct( Model $model, Nonce $nonce ) {

		$this->meta_key = $model->get_meta_key();
		$this->nonce = $nonce;
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
			<?php _e( 'Please enter the URL of the external content.', 'external-content' ); ?>
		</p>
		<table class="form-table">
			<tbody>
			<tr>
				<th scope="row">
					<label for="<?php echo $this->meta_key; ?>">
						<?php _e( 'External URL', 'external-content' ); ?>
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
