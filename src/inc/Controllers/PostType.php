<?php # -*- coding: utf-8 -*-

namespace tfrommen\ExternalContent\Controllers;

use tfrommen\ExternalContent\Models\PostType as Model;

/**
 * Post type controller.
 *
 * @package tfrommen\ExternalContent\Controllers
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
