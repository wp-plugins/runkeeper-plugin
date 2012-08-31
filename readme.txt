=== Runkeeper ===
Contributors: phy9pas
Donate link: http://sandjam.co.uk/sandjam/2010/04/runkeeper-wordpress-plugin/
Tags: runkeeper
Requires at least: 3.4.1
Tested up to: 3.4.1
Stable tag: trunk

Inserts previews of your Runkeeper activity into a post

== Description ==

There are two ways to use the plugin:

* Create a custom field in your post called "runkeeper" and paste the "Share" url from the Runkeeper activity you want to feature.

* Use the shortcode [runkeeper url="example"] replacing "example" with the "Share" url.

The map and stats for that activity will now appear in the post in an iframe.

If the formatting isn't quite right you can amend the size and offset of the Runkeeper preview in the Settings page.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Copy all the files to `/wp-content/plugins/runkeeper/`
2. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==

= 2.2 =
* Remove requirement for jQuery

= 2.1 =
* Only include Javascript on pages where runkeeper is used

= 2.0 =
* Add option to use shortcode instead of custom fields
* Settings page to control dimensions and offset of preview
* General overhaul of code to bring it in to line with the new WordPress framework

= 1.2 =
* Fixed paths issue causing JS and CSS to be missed out.

= 1.1 =
* Style amends to keep up with new Runkeper website
* Build to function without jQuery

= 1.0 =
* version one