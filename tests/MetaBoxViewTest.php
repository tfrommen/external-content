<?php # -*- coding: utf-8 -*-

use tf\ExternalContent\Views\MetaBox as Testee;
use WP_Mock\Tools\TestCase;

class MetaBoxViewTest extends TestCase {

	/**
	 * @dataProvider provide_add_data
	 *
	 * @param bool   $response
	 * @param string $current_post_type
	 * @param int    $times
	 */
	public function test_add(
		$response,
		$current_post_type,
		$times
	) {

		$model = Mockery::mock( 'tf\ExternalContent\Models\MetaBox' );
		$model->shouldReceive( 'get_meta_key' );

		$post_type = Mockery::mock( 'tf\ExternalContent\Models\PostType' );
		$post_type->shouldReceive( 'get_post_type' )
			->andReturn( 'post_type' );

		$nonce = Mockery::mock( 'tf\ExternalContent\Models\Nonce' );

		/** @var tf\ExternalContent\Models\MetaBox $model */
		/** @var tf\ExternalContent\Models\PostType $post_type */
		/** @var tf\ExternalContent\Models\Nonce $nonce */
		$testee = new Testee( $model, $post_type, $nonce );

		WP_Mock::wpPassthruFunction(
			'esc_html__',
			array(
				'times' => $times,
				'args'  => array(
					WP_Mock\Functions::type( 'string' ),
					'external-content',
				),
			)
		);

		WP_Mock::wpFunction(
			'add_meta_box',
			array(
				'times' => $times,
				'args'  => array(
					'external_content_url',
					WP_Mock\Functions::type( 'string' ),
					array( $testee, 'render' ),
					$current_post_type,
					'advanced',
					'high',
				),
			)
		);

		$this->assertSame( $response, $testee->add( $current_post_type ) );

		$this->assertConditionsMet();
	}

	/**
	 * @return array
	 */
	public function provide_add_data() {

		$post_type = 'post_type';

		return array(
			'default'         => array(
				'response'          => TRUE,
				'current_post_type' => $post_type,
				'times'             => 1,
			),
			'wrong_post_type' => array(
				'response'          => FALSE,
				'current_post_type' => 'wrong_post_type',
				'times'             => 0,
			),
		);
	}

	public function test_render() {

		$meta_key = '_external_content';

		$model = Mockery::mock( 'tf\ExternalContent\Models\MetaBox' );
		$model->shouldReceive( 'get_meta_key' )
			->andReturn( $meta_key );

		$post_type_slug = 'external_content';

		$post_type = Mockery::mock( 'tf\ExternalContent\Models\PostType' );
		$post_type->shouldReceive( 'get_post_type' )
			->andReturn( $post_type_slug );

		$nonce = Mockery::mock( 'tf\ExternalContent\Models\Nonce' );
		$nonce->shouldReceive( 'print_field' );

		/** @var tf\ExternalContent\Models\MetaBox $model */
		/** @var tf\ExternalContent\Models\PostType $post_type */
		/** @var tf\ExternalContent\Models\Nonce $nonce */
		$testee = new Testee( $model, $post_type, $nonce );

		$meta_value = 'http://example.com';

		WP_Mock::wpFunction(
			'get_post_meta',
			array(
				'times'  => 1,
				'args'   => array(
					WP_Mock\Functions::type( 'int' ),
					$meta_key,
					TRUE,
				),
				'return' => $meta_value,
			)
		);

		WP_Mock::wpFunction(
			'esc_html_e',
			array(
				'times'  => 2,
				'args'   => array(
					WP_Mock\Functions::type( 'string' ),
					'external-content',
				),
				'return' => function () {

					$args = func_get_args();
					echo $args[ 0 ];
				},
			)
		);

		WP_Mock::wpPassthruFunction(
			'esc_attr',
			array(
				'times' => 1,
				'args'  => array(
					WP_Mock\Functions::type( 'string' ),
				),
			)
		);

		$output = <<<'HTML'
		<p>
			Please enter the URL of the external content.
		</p>
		<table class="form-table">
			<tbody>
			<tr>
				<th scope="row">
					<label for="%1$s">
						External URL
					</label>
				</th>
				<td>
					<input type="url" name="%1$s" class="large-text"
						placeholder="http://example.com" value="%2$s">
				</td>
			</tr>
			</tbody>
		</table>
HTML;
		$output = sprintf( $output, $meta_key, $meta_value );

		$this->expectOutputString( $output );

		$post = Mockery::mock( 'WP_Post' );
		$post->ID = 42;

		/** @var WP_Post $post */
		$testee->render( $post );

		$this->assertConditionsMet();
	}

}
