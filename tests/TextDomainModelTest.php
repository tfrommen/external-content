<?php # -*- coding: utf-8 -*-

use tf\ExternalContent\Models\TextDomain as Testee;
use WP_Mock\Tools\TestCase;

class TextDomainModelTest extends TestCase {

	public function test_load() {

		$file = '/path/to/file.php';

		WP_Mock::wpPassthruFunction(
			'plugin_basename',
			array(
				'times' => 1,
				'args'  => array(
					WP_Mock\Functions::type( 'string' ),
				),
			)
		);

		$testee = new Testee( $file );

		$path = dirname( $file ) . '/languages';

		WP_Mock::wpFunction(
			'load_plugin_textdomain',
			array(
				'times' => 1,
				'args'  => array(
					'external-content',
					FALSE,
					$path,
				),
			)
		);

		$testee->load();

		$this->assertConditionsMet();
	}

}
