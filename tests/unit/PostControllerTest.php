<?php # -*- coding: utf-8 -*-

use tf\ExternalContent\Controllers\Post as Testee;
use WP_Mock\Tools\TestCase;

class PostControllerTest extends TestCase {

	public function test_initialize() {

		$model = Mockery::mock( 'tf\ExternalContent\Models\Post' );

		/** @var tf\ExternalContent\Models\Post $model */
		$testee = new Testee( $model );

		WP_Mock::expectFilterAdded( 'post_type_link', array( $model, 'get_external_url' ), 10, 2 );

		WP_Mock::expectFilterAdded( 'pre_get_shortlink', array( $model, 'get_shortlink' ), 10, 3 );

		$testee->initialize();

		$this->assertHooksAdded();
	}

}
