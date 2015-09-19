<?php # -*- coding: utf-8 -*-

use tfrommen\ExternalContent\Controllers\PostType as Testee;
use WP_Mock\Tools\TestCase;

class PostTypeControllerTest extends TestCase {

	public function test_initialize() {

		$model = Mockery::mock( 'tfrommen\ExternalContent\Models\PostType' );

		/** @var tfrommen\ExternalContent\Models\PostType $model */
		$testee = new Testee( $model );

		WP_Mock::expectActionAdded( 'wp_loaded', array( $model, 'register' ) );

		$testee->initialize();

		$this->assertHooksAdded();
	}

}
