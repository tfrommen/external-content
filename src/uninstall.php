<?php # -*- coding: utf-8 -*-

namespace tfrommen\ExternalContent;

use tfrommen\Autoloader;

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	return;
}

/** @var \wpdb $wpdb */
global $wpdb;

require_once __DIR__ . '/inc/Autoloader/bootstrap.php';

$autoloader = new Autoloader\Autoloader();
$autoloader->add_rule( new Autoloader\NamespaceRule( __DIR__ . '/inc', __NAMESPACE__ ) );

// Delete plugin posts
$query = "
SELECT ID
FROM {$wpdb->posts}
WHERE post_type = %s
LIMIT 500";
$post_type = new Models\PostType();
$query = $wpdb->prepare( $query, $post_type->get_post_type() );
while ( $post_ids = $wpdb->get_results( $query, ARRAY_N ) ) {
	foreach ( $post_ids as $post_id ) {
		wp_delete_post( $post_id, TRUE );
	}
}
