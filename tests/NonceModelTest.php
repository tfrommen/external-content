<?php # -*- coding: utf-8 -*-

use tf\ExternalContent\Models\Nonce as Testee;
use WP_Mock\Tools\TestCase;

class NonceModelTest extends TestCase {

	/**
	 * @dataProvider provide_get_data
	 *
	 * @param string $response
	 * @param string $action
	 */
	public function test_get( $response, $action ) {

		$testee = new Testee( 'class_action' );

		WP_Mock::wpPassthruFunction(
			'wp_create_nonce',
			array(
				'times' => 1,
				'args'  => array(
					WP_Mock\Functions::type( 'string' ),
				),
			)
		);

		$this->assertSame( $response, $testee->get( $action ) );

		$this->assertConditionsMet();
	}

	/**
	 * @return array
	 */
	public function provide_get_data() {

		$action = 'action';

		$class_action = 'class_action';

		return array(
			'default'      => array(
				$action,
				$action,
				$class_action,
			),
			'empty_action' => array(
				$class_action,
				'',
				$class_action,
			),
		);
	}

	/**
	 * @dataProvider provide_get_data
	 *
	 * @param string $response
	 * @param string $action
	 */
	public function test_get_field( $response, $action ) {

		$testee = new Testee( 'class_action' );

		WP_Mock::wpPassthruFunction(
			'wp_nonce_field',
			array(
				'times' => 1,
				'args'  => array(
					WP_Mock\Functions::type( 'string' ),
					WP_Mock\Functions::type( 'string' ),
					WP_Mock\Functions::type( 'bool' ),
					WP_Mock\Functions::type( 'bool' ),
				),
			)
		);

		$this->assertSame( $response, $testee->get_field( $action ) );

		$this->assertConditionsMet();
	}

	/**
	 * @dataProvider provide_get_data
	 *
	 * @param string $response
	 * @param string $action
	 */
	public function test_print_field( $response, $action ) {

		$testee = new Testee( 'class_action' );

		WP_Mock::wpFunction(
			'wp_nonce_field',
			array(
				'times'  => 1,
				'args'   => array(
					WP_Mock\Functions::type( 'string' ),
					WP_Mock\Functions::type( 'string' ),
					WP_Mock\Functions::type( 'bool' ),
					TRUE,
				),
				'return' => function ( $param ) {

					echo $param;
				},
			)
		);

		$this->expectOutputString( $response );

		$testee->print_field( $action );

		$this->assertConditionsMet();
	}

	/**
	 * @dataProvider provide_is_valid_data
	 *
	 * @param bool   $response
	 * @param string $nonce
	 * @param string $action
	 * @param int    $times
	 * @param string $request_value
	 */
	public function test_is_valid(
		$response,
		$nonce,
		$action,
		$times,
		$request_value
	) {

		$class_action = 'class_action';

		$name = 'name';

		$testee = new Testee( $class_action, $name );

		$_REQUEST[ $name ] = $request_value;

		WP_Mock::wpFunction(
			'wp_verify_nonce',
			array(
				'times'  => $times,
				'args'   => array(
					WP_Mock\Functions::type( 'string' ),
					WP_Mock\Functions::type( 'string' ),
				),
				'return' => function ( $nonce, $nonce_action ) use ( $action, $class_action ) {

					return (
						$nonce === 'nonce'
						&& (
							$nonce_action === 'action'
							|| (
								$nonce_action === $class_action
								&& $action === ''
							)
						)
					);
				},
			)
		);

		$this->assertSame( $response, $testee->is_valid( $nonce, $action ) );

		$this->assertConditionsMet();
	}

	/**
	 * @return array
	 */
	public function provide_is_valid_data() {

		$nonce = 'nonce';

		$action = 'action';

		return array(
			'nonce_not_empty'                   => array(
				'response'      => TRUE,
				'nonce'         => $nonce,
				'action'        => $action,
				'times'         => 1,
				'request_value' => '',
			),
			'nonce_in_request'                  => array(
				'response'      => TRUE,
				'nonce'         => '',
				'action'        => $action,
				'times'         => 1,
				'request_value' => $nonce,
			),
			'nonce_not_empty_and_action_empty'  => array(
				'response'      => TRUE,
				'nonce'         => $nonce,
				'action'        => '',
				'times'         => 1,
				'request_value' => '',
			),
			'nonce_in_request_and_action_empty' => array(
				'response'      => TRUE,
				'nonce'         => '',
				'action'        => '',
				'times'         => 1,
				'request_value' => $nonce,
			),
			'nonce_empty_and_not_in_request'    => array(
				'response'      => FALSE,
				'nonce'         => '',
				'action'        => $action,
				'times'         => 0,
				'request_value' => '',
			),
		);
	}

}
