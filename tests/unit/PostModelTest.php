<?php # -*- coding: utf-8 -*-

use tfrommen\ExternalContent\Models\Post as Testee;
use WP_Mock\Tools\TestCase;

class PostModelTest extends TestCase {

	/**
	 * @dataProvider provide_get_external_url_data
	 *
	 * @param string      $response
	 * @param string      $post_link
	 * @param WP_Post     $post
	 * @param bool        $use_external_url
	 * @param int         $times
	 * @param string|bool $post_meta
	 */
	public function test_get_external_url(
		$response,
		$post_link,
		$post,
		$use_external_url,
		$times,
		$post_meta
	) {

		$post_type = Mockery::mock( 'tfrommen\ExternalContent\Models\PostType' );
		$post_type->shouldReceive( 'get_post_type' )
			->andReturn( 'post_type' );

		$meta_box = Mockery::mock( 'tfrommen\ExternalContent\Models\MetaBox' );
		$meta_box->shouldReceive( 'get_meta_key' )
			->andReturn( 'meta_key' );

		/** @var tfrommen\ExternalContent\Models\PostType $post_type */
		/** @var tfrommen\ExternalContent\Models\MetaBox $meta_box */
		$testee = new Testee( $post_type, $meta_box );

		WP_Mock::onFilter( 'external_content_use_external_url' )
			->with( TRUE )
			->reply( $use_external_url );

		WP_Mock::wpFunction(
			'get_post_meta',
			array(
				'times'  => $times,
				'args'   => array(
					WP_Mock\Functions::type( 'int' ),
					WP_Mock\Functions::type( 'string' ),
					TRUE,
				),
				'return' => $post_meta,
			)
		);

		$this->assertSame( $response, $testee->get_external_url( $post_link, $post ) );

		$this->assertConditionsMet();
	}

	/**
	 * @return array
	 */
	public function provide_get_external_url_data() {

		$post_link = 'post_link';

		$post = Mockery::mock( 'WP_Post' );
		$post->ID = 42;
		$post->post_type = 'post_type';

		$wrong_post = Mockery::mock( 'WP_Post' );
		$wrong_post->ID = 42;
		$wrong_post->post_type = 'wrong_post_type';

		$extermal_url = 'external_url';

		return array(
			'default'                 => array(
				'response'         => $extermal_url,
				'post_link'        => $post_link,
				'post'             => $post,
				'use_external_url' => TRUE,
				'times'            => 1,
				'post_meta'        => $extermal_url,
			),
			'no_post'                 => array(
				'response'         => $post_link,
				'post_link'        => $post_link,
				'post'             => NULL,
				'use_external_url' => TRUE,
				'times'            => 0,
				'post_meta'        => $extermal_url,
			),
			'wrong_post'              => array(
				'response'         => $post_link,
				'post_link'        => $post_link,
				'post'             => $wrong_post,
				'use_external_url' => TRUE,
				'times'            => 0,
				'post_meta'        => $extermal_url,
			),
			'do_not_use_external_url' => array(
				'response'         => $post_link,
				'post_link'        => $post_link,
				'post'             => $post,
				'use_external_url' => FALSE,
				'times'            => 0,
				'post_meta'        => $extermal_url,
			),
			'no_external_url'         => array(
				'response'         => '',
				'post_link'        => $post_link,
				'post'             => $post,
				'use_external_url' => TRUE,
				'times'            => 1,
				'post_meta'        => FALSE,
			),
		);
	}

	/**
	 * @dataProvider provide_get_shortlink_data
	 *
	 * @param string|bool $response
	 * @param string|bool $return
	 * @param string      $context
	 * @param int         $times
	 * @param WP_Post     $post
	 *
	 * @return void
	 */
	public function test_get_shortlink(
		$response,
		$return,
		$context,
		$times,
		$post
	) {

		$post_type = Mockery::mock( 'tfrommen\ExternalContent\Models\PostType' );
		$post_type->shouldReceive( 'get_post_type' )
			->andReturn( 'post_type' );

		$meta_box = Mockery::mock( 'tfrommen\ExternalContent\Models\MetaBox' );
		$meta_box->shouldReceive( 'get_meta_key' );

		/** @var tfrommen\ExternalContent\Models\PostType $post_type */
		/** @var tfrommen\ExternalContent\Models\MetaBox $meta_box */
		$testee = new Testee( $post_type, $meta_box );

		WP_Mock::wpFunction(
			'get_post',
			array(
				'times'  => $times,
				'args'   => array(
					WP_Mock\Functions::type( 'int' ),
				),
				'return' => $post,
			)
		);

		$this->assertSame( $response, $testee->get_shortlink( $return, 42, $context ) );

		$this->assertConditionsMet();
	}

	/**
	 * @return array
	 */
	public function provide_get_shortlink_data() {

		$return = 'return';

		$context = 'post';

		$post = Mockery::mock( 'WP_Post' );
		$post->post_type = 'post_type';

		$wrong_post = Mockery::mock( 'WP_Post' );
		$wrong_post->post_type = 'wrong_post_type';

		return array(
			'default'         => array(
				'response' => '',
				'return'   => $return,
				'context'  => $context,
				'times'    => 1,
				'post'     => $post,
			),
			'wrong_context'   => array(
				'response' => $return,
				'return'   => $return,
				'context'  => 'wrong_context',
				'times'    => 0,
				'post'     => $post,
			),
			'no_post'         => array(
				'response' => $return,
				'return'   => $return,
				'context'  => $context,
				'times'    => 1,
				'post'     => NULL,
			),
			'wrong_post_type' => array(
				'response' => $return,
				'return'   => $return,
				'context'  => $context,
				'times'    => 1,
				'post'     => $wrong_post,
			),
		);
	}

}
