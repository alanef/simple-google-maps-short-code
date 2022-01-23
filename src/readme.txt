=== Simple Shortcode for GoogleMaps ===
Contributors: alanfuller, fullworks
Donate Link: https://www.paypal.com/donate/?hosted_button_id=UGRBY5CHSD53Q
Author URI: https://fullworks.net
Contributors: fullworks,alanfuller
Tags: google maps, google map, google maps shortcode, gmaps, maps, map, gmap, map markers, google maps plugin, map plugin, map builder
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tested up to: 5.9
Stable tag: 1.5

A simple shortcode for embedding Google Maps in any WordPress post, page or widget.

== Description ==

Simple to use, yet powerful, Google Maps plugin! Reviews say this is "Best Google Map Shortcode plugin".

Put a Google map on your WordPress posts and pages simply and easily with a shortcode. Straight forward and easy to use! Ideal for contact page maps, maps showing delivery areas and many other uses!

This plugin will enable a simple shortcode that you can use for embedding Google Maps in any WordPress post or page. The shortcode uses the [WordPress HTTPS API](https://developer.wordpress.org/plugins/http-api/) and the [Transients API](https://developer.wordpress.org/apis/handbook/transients/) for delivering cached Google maps with little to no impact on your site's performance.

Maps are displayed with the [pw_map] shortcode:

`[pw_map address="New York City" key="YOUR API KEY"]`

Google now requires that new accounts use an API key. You can register a free API key [here](https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key).

You can have multiple map pins, simply add multiple addresses separated by semi-colon `;`

`[pw_map address="Statue of Liberty National Monument NYC;Empire State Building, New York, NY, USA" key="YOUR API KEY"]`

== Frequently Asked Questions ==

1. Can I change the width or height of the map?

Yes, simply supply a width and height parameter:

`[pw_map address="New York City" width="400px" height="200px" key="YOUR API KEY"]`

You can also use percentages for heights:

`[pw_map address="New York City" width="50%" height="200px" key="YOUR API KEY"]`

2. Can I disable the scroll wheel?

Yes, simple add `enablescrollwheel="false"` to the maps shortcode.

`[pw_map address="New York City" enablescrollwheel="false" key="YOUR API KEY"]`

3. Can I disable the map controls?

Yes, simple add `disablecontrols="true"` to the shortcode.

`[pw_map address="New York City" disablecontrols="true" key="YOUR API KEY"]`

4. How are the maps cached?

Maps are cached using the WordPress [Transients API](http://codex.wordpress.org/Transients_API), which allows for very simple database-based caching.

Each time you display a map, the address specified is used to generate a unique md5 hash, which is used for the cache identifier. This means that if you change the address used for your map, the cache will be refreshed.

5. How often do caches refresh?

The maps are cached for 3 months. Caches are automatically cleared (for individual maps) when you change the address in the shortcode.

== Installation ==

1. Activate the plugin.
2. Obtain an API key [here](https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key).
3. Added [pw_map address="your address here" key="YOUR API KEY"] to any post or page.

== Changelog ==
= 1.5 =
* Allow multiple address pins

= 1.4.1 =
* load google maps cookieless to help with GDPR compliance

= 1.4.0 =
* add donation info to settings

= 1.3.3 =
* Fix block editor issue

= 1.3.2 =

* Fix: few API key related issues

= 1.3.1 =

* Fix: API key was not passed to the pw_map_get_coordinates() function

= 1.3 =

* Added `key` parameter to the [pw_map] shortcode.

= 1.2 =

* Added missing load_plugin_textdomain()
* Changed textdomain for language packs

= 1.1.2 =

* Fixed a bug with the zoom parameter not working

= 1.1.1 =

* Fixed a bug with sites on HTTPS

= 1.1 =

* Added support for disabling map controls via disablecontrols="true", thanks to Alex Hochberger
* Added support for disabling the scroll wheel zoom via enablescrollwheel="false", thanks to Alex Hochberger

= 1.0.3 =

* Fixed a conflict with the Live Composer plugin.

= 1.0.2 =

* Updated Google Maps API to fix broken maps after version 2 was deprecated on March 8, 2013
* Improved error responses

= 1.0.1 =

* Added CSS to fix a problem with responsive themes

= 1.0 =

* First release!
