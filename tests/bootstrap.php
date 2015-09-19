<?php # -*- coding: utf-8 -*-

$parent_dir = dirname( __DIR__ ) . '/';

require_once $parent_dir . 'vendor/autoload.php';

$inc_dir = "$parent_dir/src/inc/";

require_once $inc_dir . 'Autoloader/bootstrap.php';

$autoloader = new tfrommen\Autoloader\Autoloader();
$autoloader->add_rule( new tfrommen\Autoloader\NamespaceRule( $inc_dir, 'tfrommen\ExternalContent' ) );
