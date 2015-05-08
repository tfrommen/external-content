<?php # -*- coding: utf-8 -*-

namespace tf\ExternalContent\Controller;

use tf\ExternalContent\Model\Post as Model;

/**
 * Class Post
 *
 * @package tf\ExternalContent\Controller
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
