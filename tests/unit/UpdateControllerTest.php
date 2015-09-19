<?php # -*- coding: utf-8 -*-

use tfrommen\ExternalContent\Controllers\Update as Testee;
use WP_Mock\Tools\TestCase;

/**
 * Test case for the UpdateController class.
 */
class UpdateControllerTest extends TestCase {

	/**
	 * @covers       tfrommen\ExternalContent\Controllers\Update::update
	 * @dataProvider provide_update_data
	 *
	 * @param bool   $expected
	 * @param string $version
	 * @param string $old_version
	 * @param int    $times_update_option
	 *
	 * @return void
	 */
	public function test_update( $expected, $version, $old_version, $times_update_option ) {

		$testee = new Testee( $version );

		WP_Mock::wpFunction(
			'get_option',
			array(
				'times'  => 1,
				'args'   => array(
					Mockery::type( 'string' ),
				),
				'return' => $old_version,
			)
		);

		WP_Mock::wpFunction(
			'update_option',
			array(
				'times' => $times_update_option,
				'args'  => array(
					Mockery::type( 'string' ),
					$version,
				),
			)
		);

		$this->assertSame( $expected, $testee->update() );

		$this->assertConditionsMet();
	}

	/**
	 * Provider for the test_update() method.
	 *
	 * @return array
	 */
	public function provide_update_data() {

		$version = '9.9.9';

		return array(
			'no_version'      => array(
				'expected'            => TRUE,
				'version'             => $version,
				'old_version'         => '',
				'times_update_option' => 1,
			),
			'old_version'     => array(
				'expected'            => TRUE,
				'version'             => $version,
				'old_version'         => '0',
				'times_update_option' => 1,
			),
			'current_version' => array(
				'expected'            => FALSE,
				'version'             => $version,
				'old_version'         => $version,
				'times_update_option' => 0,
			),
		);
	}

}