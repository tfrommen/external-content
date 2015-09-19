<?php # -*- coding: utf-8 -*-

use tfrommen\ExternalContent\Controllers\MetaBox as Testee;
use WP_Mock\Tools\TestCase;

class ScriptControllerTest extends TestCase {

	public function test_initialize() {

		$model = Mockery::mock( 'tfrommen\ExternalContent\Models\MetaBox' );

		$view = Mockery::mock( 'tfrommen\ExternalContent\Views\MetaBox' );

		/** @var tfrommen\ExternalContent\Models\MetaBox $model */
		/** @var tfrommen\ExternalContent\Views\MetaBox $view */
		$testee = new Testee( $model, $view );

		WP_Mock::expectActionAdded( 'add_meta_boxes', array( $view, 'add' ) );

		WP_Mock::expectActionAdded( 'save_post', array( $model, 'save' ), 10, 2 );

		$testee->initialize();

		$this->assertHooksAdded();
	}

}
