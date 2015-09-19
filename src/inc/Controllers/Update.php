<?php # -*- coding: utf-8 -*-

namespace tfrommen\ExternalContent\Controllers;

/**
 * Update controller.
 *
 * @package tfrommen\ExternalContent\Controllers
 */
class Update {

	/**
	 * @var string
	 */
	private $version;

	/**
	 * @var string
	 */
	private $version_option_name = 'external_content_version';

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param string $version Current plugin version.
	 */
	public function __construct( $version ) {

		$this->version = $version;
	}

	/**
	 * Update the plugin.
	 *
	 * @return bool
	 */
	public function update() {

		$old_version = (string) get_option( $this->version_option_name );
		if ( $old_version === $this->version ) {
			return FALSE;
		}

		update_option( $this->version_option_name, $this->version );

		return TRUE;
	}

}
