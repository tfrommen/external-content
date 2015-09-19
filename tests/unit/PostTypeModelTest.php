<?php # -*- coding: utf-8 -*-

use tfrommen\ExternalContent\Models\PostType as Testee;
use WP_Mock\Tools\TestCase;

class PostTypeModelTest extends TestCase {

	public function test_register() {

		$testee = new Testee();

		WP_Mock::wpPassthruFunction(
			'_x',
			array(
				'args' => array(
					WP_Mock\Functions::type( 'string' ),
					WP_Mock\Functions::type( 'string' ),
					'external-content',
				),
			)
		);

		WP_Mock::wpPassthruFunction(
			'__',
			array(
				'args' => array(
					WP_Mock\Functions::type( 'string' ),
					'external-content',
				),
			)
		);

		WP_Mock::wpFunction(
			'register_post_type',
			array(
				'times' => 1,
				'args'  => array(
					'external_content',
					WP_Mock\Functions::type( 'array' ),
				),
			)
		);
		$testee->register();

		$this->assertConditionsMet();
	}

	public function test_customize_meta_boxes() {

		$testee = new Testee();

		WP_Mock::wpFunction(
			'remove_meta_box',
			array(
				'times' => 1,
				'args'  => array(
					WP_Mock\Functions::type( 'string' ),
					WP_Mock\Functions::type( 'string' ),
					WP_Mock\Functions::type( 'string' ),
				),
			)
		);

		$testee->customize_meta_boxes();

		$this->assertConditionsMet();
	}

}
