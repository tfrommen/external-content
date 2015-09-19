=== External Content ===
Contributors: tfrommen
Tags: content, external, url
Requires at least: 2.9.0
Tested up to: 4.3.1
Stable tag: trunk

This plugin registers a custom post type to handle external content like any other post. The post permalink is replaced by a custom post meta that holds an external URL.

== Description ==

Have you ever wanted to integrate external content such as a specific post of an external website into your WordPress website? But treat it like any other post? That is, have it appear as teaser or part of a specific (pseudo) archive?

This is exactly when _External Content_ kicks in.

= Usage =

_External Content_ registers a custom post type that, by default, supports title, content, excerpt and thumbnail. This can be customized, though. Managing your posts in your backend is no different from any other post type. Create a new post, give it a title, write some text, define an individual excerpt, and set a post thumbnail, if you wish. Then assign each post an individual external URL by means of the according meta box. This external URL will be used as the post's permalink.

**Filters**

In order to customize certain aspects of the plugin, it provides you with several filters. For each of these, a short description as well as a code example on how to alter the default behavior is given below. Just put the according code snippet in your theme's `functions.php` file or your _customization_ plugin, or to some other appropriate place.

**`external_content_args`**

If you want to alter a specific post type argument but you can't find a fitting filter, there's `external_content_args`, which provides you with the complete args array.

`
/**
 * Filter the post type args.
 *
 * @param array $args Post type args.
 */
add_filter( 'external_content_args', function( $args ) {

	// Use hierarchical external content
	$args[ 'hierarchical' ] = TRUE;

	return $args;
} );
`

**`external_content_description`**

The post type description can be customized by using the `external_content_description` filter.

`
/**
 * Filter the post type description.
 *
 * @param string $description Post type description.
 */
add_filter( 'external_content_description', function() {

	// Provide a description
	return 'Simple post type for handling external content like any other post.';
} );
`

**`external_content_labels`**

In case you don't like the labels, easily adapt them to your liking.

`
/**
 * Filter the post type labels.
 *
 * @param array $labels Post type labels.
 */
add_filter( 'external_content_labels', function( $labels ) {

	// A little more horror, please...
	$labels[ 'not_found' ] = 'ZOMG, no external content found!!1!!1!!oneone!!!1!eleven!1!';

	return $labels;
} );
`

**`external_content_meta_key`**

If you want to alter the meta key for the external URL, feel free to do it via this filter.

`
/**
 * Filter the meta key.
 *
 * @param string $meta_key Meta key.
 */
add_filter( 'external_content_meta_key', function() {

	// Let's Shrekify the meta key
	return 'far_far_away';
} );
`

**`external_content_post_type`**

Yes, you can also alter the post type (slug).

`
/**
 * Filter the post type.
 *
 * @param string $post_type Post type.
 */
add_filter( 'external_content_post_type', function() {

	return 'exotic_stuff';
} );
`

**`external_content_supports`**

This filter provides you with the post type supports.

`
/**
 * Filter the post type supports.
 *
 * @param array $supports Post type supports.
 */
add_filter( 'external_content_supports', function( $supports ) {

	// If your theme uses the excerpt for teasers, just remove the editor to prevent confusion
	foreach ( $supports as $key => $value ) {
		if ( 'editor' === $value ) {
			unset( $supports[ $key ] );
		}
	}

	return $supports;
} );
`

**`external_content_use_external_url`**

The permalink of external content is, by default, replaced with the post's according external URL (i.e., post meta). To disable this behavior, just do the following:

`
/**
 * Filter the usage of the external URL as permalink.
 *
 * @param bool $use_external_url Use the external URL as permalink?
 */
add_filter( 'external_content_use_external_url', '__return_false' );
`

= Contribution =

To **contribute** to this plugin, please see its <a href="https://github.com/tfrommen/external-content" target="_blank">**GitHub repository**</a>.

If you have a feature request, or if you have developed the feature already, please feel free to use the Issues and/or Pull Requests section.

Of course, you can also provide me with translations if you would like to use the plugin in another not yet included language.

== Installation ==

This plugin requires PHP 5.3.

1. Upload the `external-content` folder to the `/wp-content/plugins/` directory on your web server.
1. Activate the plugin through the _Plugins_ menu in WordPress.
1. Find the new _External Content_ menu in your WordPress backend.

== Screenshots ==

1. **Meta box** - Enter an external URL to have the post's permalink be replaced with it.

== Changelog ==

= 1.4.0 =
* Compatible up to WordPress 4.3.1.

= 1.3.0 =
* Bugfix Nonce method.
* Refactor some methods to make them better testable.
* Compatible up to WordPress 4.3.

= 1.2.1 =
* Escape translated strings.
* Compatible up to WordPress 4.2.4.

= 1.2.0 =
* Complete refactor.
* Compatible up to WordPress 4.2.3.

= 1.1.0 =
* wordpress.org release.
* Compatible up to WordPress 4.2.2.

= 1.0.0 =
* Initial release.
