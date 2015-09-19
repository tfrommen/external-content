<?php # -*- coding: utf-8 -*-

use tf\ExternalContent\Models\MetaBox as Testee;
use WP_Mock\Tools\TestCase;

class MetaBoxModelTest extends TestCase {

	/**
	 * @dataProvider  provide_save_data
	 *
	 * @param bool    $response
	 * @param WP_Post $post
	 * @param bool    $is_nonce_valid
	 * @param bool    $is_post_revision
	 * @param int     $user_can_times
	 * @param bool    $user_can
	 * @param int     $update_times
	 */
	public function test_save(
		$response,
		WP_Post $post,
		$is_nonce_valid,
		$is_post_revision,
		$user_can_times,
		$user_can,
		$update_times
	) {

		$post_type = Mockery::mock( 'tf\ExternalContent\Models\PostType' );
		$post_type->shouldReceive( 'get_post_type' )
			->andReturn( 'post_type' );

		$nonce = Mockery::mock( 'tf\ExternalContent\Models\Nonce' );
		$nonce->shouldReceive( 'is_valid' )
			->andReturn( $is_nonce_valid );

		$meta_key = 'meta_key';

		WP_Mock::onFilter( 'external_content_meta_key' )
			->with( '_external_content' )
			->reply( $meta_key );

		WP_Mock::wpPassthruFunction(
			'esc_attr',
			array(
				'times' => 1,
				'args'  => array(
					WP_Mock\Functions::type( 'string' ),
				),
			)
		);

		/** @var tf\ExternalContent\Models\PostType $post_type */
		/** @var tf\ExternalContent\Models\Nonce $nonce */
		$testee = new Testee( $post_type, $nonce );

		WP_Mock::wpFunction(
			'wp_is_post_revision',
			array(
				'times'  => 1,
				'args'   => array(
					WP_Mock\Functions::type( 'int' ),
				),
				'return' => $is_post_revision,
			)
		);

		WP_Mock::wpFunction(
			'current_user_can',
			array(
				'times'  => $user_can_times,
				'args'   => array(
					'edit_post',
					WP_Mock\Functions::type( 'int' ),
				),
				'return' => $user_can,
			)
		);

		$meta_value = 'meta_value';

		$_POST[ $meta_key ] = $meta_value;

		WP_Mock::wpFunction(
			'update_post_meta',
			array(
				'times'  => $update_times,
				'args'   => array(
					WP_Mock\Functions::type( 'int' ),
					$meta_key,
					$meta_value,
				),
				'return' => $response,
			)
		);

		/** @var WP_Post $post */
		$this->assertSame( $response, $testee->save( 42, $post ) );

		$this->assertConditionsMet();
	}

	/**
	 * @return array
	 */
	public function provide_save_data() {

		$post = Mockery::mock( 'WP_Post' );
		$post->post_type = 'post_type';

		$wrong_post = Mockery::mock( 'WP_Post' );
		$wrong_post->post_type = 'wrong_post_type';

		return array(
			'default'          => array(
				'response'         => TRUE,
				'post'             => $post,
				'is_nonce_valid'   => TRUE,
				'is_post_revision' => FALSE,
				'user_can_times'   => 1,
				'user_can'         => TRUE,
				'update_times'     => 1,
			),
			'post_revision'    => array(
				'response'         => FALSE,
				'post'             => $post,
				'is_nonce_valid'   => TRUE,
				'is_post_revision' => TRUE,
				'user_can_times'   => 0,
				'user_can'         => TRUE,
				'update_times'     => 0,
			),
			'wrong_post_type'  => array(
				'response'         => FALSE,
				'post'             => $wrong_post,
				'is_nonce_valid'   => TRUE,
				'is_post_revision' => FALSE,
				'user_can_times'   => 0,
				'user_can'         => TRUE,
				'update_times'     => 0,
			),
			'user_cannot_edit' => array(
				'response'         => FALSE,
				'post'             => $post,
				'is_nonce_valid'   => TRUE,
				'is_post_revision' => FALSE,
				'user_can_times'   => 1,
				'user_can'         => FALSE,
				'update_times'     => 0,
			),
			'invalid_nonce'    => array(
				'response'         => FALSE,
				'post'             => $post,
				'is_nonce_valid'   => FALSE,
				'is_post_revision' => FALSE,
				'user_can_times'   => 1,
				'user_can'         => TRUE,
				'update_times'     => 0,
			),
		);
	}

}
