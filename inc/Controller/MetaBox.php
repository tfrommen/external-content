<?php # -*- coding: utf-8 -*-

namespace tf\ExternalContent\Controller;

use tf\ExternalContent\Model\MetaBox as Model;

/**
 * Class MetaBox
 *
 * @package tf\ExternalContent\Controller
 */
class MetaBox {

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

		add_action( 'add_meta_boxes', array( $this->model, 'add' ) );
		add_action( 'save_post', array( $this->model, 'save' ), 10, 2 );
	}

}
