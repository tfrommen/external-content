<?php # -*- coding: utf-8 -*-

namespace tfrommen\Autoloader;

/**
 * Interface for autoloader rules.
 *
 * @package tfrommen\Autoloader
 */
interface Rule {

	/**
	 * Load a class or an interface.
	 *
	 * @param string $name Class or interface name.
	 *
	 * @return bool
	 */
	public function autoload( $name );

}
