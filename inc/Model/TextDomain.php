<?php # -*- coding: utf-8 -*-

namespace tf\ExternalContent\Model;

/**
 * Class TextDomain
 *
 * @package tf\ExternalContent\Model
 */
class TextDomain {

	/**
	 * @var string
	 */
	private $path;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @see tf\ExternalContent\Plugin::initialize()
	 *
	 * @param string $file Main plugin file.
	 */
	public function __construct( $file ) {

		$this->path = plugin_basename( $file );
		$this->path = dirname( $this->path ) . '/languages';
	}

	/**
	 * Load the text domain.
	 *
	 * @see tf\ExternalContent\Controller\TextDomain::initialize()
	 *
	 * @return void
	 */
	public function load() {

		load_plugin_textdomain( 'external-content', FALSE, $this->path );
	}

}
