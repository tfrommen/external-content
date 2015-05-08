<?php # -*- coding: utf-8 -*-

namespace tf\ExternalContent\Controller;

use tf\ExternalContent\Model\PostType as Model;

/**
 * Class PostType
 *
 * @package tf\ExternalContent\Controller
 */
class PostType {

	/**
	 * @var Model
	 */
	private $model;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param Model $model Model.
	 */
	public function __construct( Model $model ) {

		$this->model = $model;
	}

	/**
	 * Wire up all functions.
	 *
	 * @return void
	 */
	public function initialize() {

		add_action( 'wp_loaded', array( $this->model, 'register' ) );
	}

}
