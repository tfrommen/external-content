<?php # -*- coding: utf-8 -*-

namespace tf\ExternalContent;

use tf\ExternalContent\Controller;
use tf\ExternalContent\Model;

/**
 * Class Plugin
 *
 * @package tf\ExternalContent
 */
class Plugin {

	/**
	 * @var string
	 */
	private $file;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param string $file Main plugin file.
	 */
	public function __construct( $file ) {

		$this->file = $file;
	}

	/**
	 * Initialize the plugin.
	 *
	 * @return void
	 */
	public function initialize() {

		$text_domain = new Model\TextDomain( $this->file );
		$text_domain->load();

		$post_type = new Model\PostType();
		$post_type_controller = new Controller\PostType( $post_type );
		$post_type_controller->initialize();

		$meta_box = new Model\MetaBox( $post_type );
		$meta_box_controller = new Controller\MetaBox( $meta_box );
		$meta_box_controller->initialize();

		$post = new Model\Post( $post_type, $meta_box );
		$post_controller = new Controller\Post( $post );
		$post_controller->initialize();
	}

}
