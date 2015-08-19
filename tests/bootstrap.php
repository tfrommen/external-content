<?php # -*- coding: utf-8 -*-

$parent_dir = dirname( __DIR__ ) . '/';

require_once $parent_dir . 'vendor/autoload.php';

require_once $parent_dir . 'inc/Autoloader/bootstrap.php';
$autoloader = new tf\Autoloader\Autoloader();
$autoloader->add_rule( new tf\Autoloader\NamespaceRule( $parent_dir . 'inc', 'tf\ExternalContent' ) );
