<?php # -*- coding: utf-8 -*-

namespace tfrommen\ExternalContent\Controllers;

use tfrommen\ExternalContent\Models\Post as Model;

/**
 * Post controller.
 *
 * @package tfrommen\ExternalContent\Controllers
 */
class Post {

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

		add_filter( 'post_type_link', array( $this->model, 'get_external_url' ), 10, 2 );

		add_filter( 'pre_get_shortlink', array( $this->model, 'get_shortlink' ), 10, 3 );
	}

}
