<?php # -*- coding: utf-8 -*-

namespace tfrommen\ExternalContent;

/**
 * Main controller.
 *
 * @package tfrommen\ExternalContent
 */
class Plugin {

	/**
	 * @var string
	 */
	private $file;

	/**
	 * @var string
	 */
	private $plugin_data;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param string $file Main plugin file.
	 */
	public function __construct( $file ) {

		$this->file = $file;

		$headers = array(
			'version'     => 'Version',
			'text_domain' => 'Text Domain',
			'domain_path' => 'Domain Path',
		);
		$this->plugin_data = get_file_data( $file, $headers );
	}

	/**
	 * Initialize the plugin.
	 *
	 * @return void
	 */
	public function initialize() {

		$update_controller = new Controllers\Update( $this->plugin_data[ 'version' ] );
		$update_controller->update();

		$text_domain = new Models\TextDomain(
			$this->file,
			$this->plugin_data[ 'text_domain' ],
			$this->plugin_data[ 'domain_path' ]
		);
		$text_domain->load();

		$nonce = new Models\Nonce( 'save_external_url' );

		$post_type = new Models\PostType();
		$post_type_controller = new Controllers\PostType( $post_type );
		$post_type_controller->initialize();

		$meta_box = new Models\MetaBox( $post_type, $nonce );
		$meta_box_view = new Views\MetaBox( $meta_box, $post_type, $nonce );
		$meta_box_controller = new Controllers\MetaBox( $meta_box, $meta_box_view );
		$meta_box_controller->initialize();

		$post = new Models\Post( $post_type, $meta_box );
		$post_controller = new Controllers\Post( $post );
		$post_controller->initialize();
	}

}
