<?php # -*- coding: utf-8 -*-

use tfrommen\ExternalContent\Models\TextDomain as Testee;
use WP_Mock\Tools\TestCase;

/**
 * Test case for the TextDomainModel class.
 */
class TextDomainModelTest extends TestCase {

	/**
	 * @covers tfrommen\ExternalContent\Models\TextDomain::load
	 *
	 * @return void
	 */
	public function test_load() {

		$file = '/path/to/file.php';

		$domain = 'text-domain';

		$path = '/domain';

		WP_Mock::wpPassthruFunction(
			'plugin_basename',
			array(
				'times' => 1,
				'args'  => array(
					WP_Mock\Functions::type( 'string' ),
				),
			)
		);

		$testee = new Testee( $file, $domain, $path );

		$path = dirname( $file ) . $path;

		WP_Mock::wpFunction(
			'load_plugin_textdomain',
			array(
				'times' => 1,
				'args'  => array(
					$domain,
					FALSE,
					$path,
				),
			)
		);

		$testee->load();

		$this->assertConditionsMet();
	}

}
