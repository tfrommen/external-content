<?php # -*- coding: utf-8 -*-

use tf\ExternalContent\Controllers\PostType as Testee;
use WP_Mock\Tools\TestCase;

class PostTypeControllerTest extends TestCase {

	public function test_initialize() {

		$model = Mockery::mock( 'tf\ExternalContent\Models\PostType' );

		/** @var tf\ExternalContent\Models\PostType $model */
		$testee = new Testee( $model );

		WP_Mock::expectActionAdded( 'wp_loaded', array( $model, 'register' ) );

		$testee->initialize();

		$this->assertHooksAdded();
	}

}
