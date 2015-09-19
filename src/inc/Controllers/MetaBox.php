<?php # -*- coding: utf-8 -*-

namespace tf\ExternalContent\Controllers;

use tf\ExternalContent\Models\MetaBox as Model;
use tf\ExternalContent\Views\MetaBox as View;

/**
 * Class MetaBox
 *
 * @package tf\ExternalContent\Controllers
 */
class MetaBox {

	/**
	 * @var Model
	 */
	private $model;

	/**
	 * @var View
	 */
	private $view;

	/**
	 * Constructor. Set up the properties.
	 *
	 * @param Model $model Model.
	 * @param View  $view  View.
	 */
	public function __construct( Model $model, View $view ) {

		$this->model = $model;

		$this->view = $view;
	}

	/**
	 * Wire up all functions.
	 *
	 * @return void
	 */
	public function initialize() {

		add_action( 'add_meta_boxes', array( $this->view, 'add' ) );
		add_action( 'save_post', array( $this->model, 'save' ), 10, 2 );
	}

}
