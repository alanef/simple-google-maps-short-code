=== Simple Shortcode for Google Maps ===
Contributors: alanfuller, fullworks
Donate link: https://ko-fi.com/wpalan
Author URI: https://fullworks.net start
Contributors: fullworks,alanfuller
Tags: google maps, google maps shortcode, gmaps, maps, google maps plugin
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tested up to: 6.7
Stable tag: 1.6

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

=== All Shortcode Options ===
Mandatory
<li>address  - Description: The address you want pinned - Allowed values: any address that Google can find, multi addresses separated by ;</li>
<li>key - Description: Your Google Maps API Key - Allowed values: valid key</li>


Optional ( with default values)
<li>width - Description: sets the map width - Default: 100% - Allowed values: size in % or px</li>
<li>height - Description: sets the map height - Default: 400px - Allowed values: size in % or px</li>
<li>enablescrollwheel - Description: zooming on the map using a mouse scroll wheel  - Default: true - Allowed values: true or false</li>
<li>zoom - Description: The initial Map zoom level - Default: 15 - Allowed values: Valid zoom values are numbers from zero up to the supported maximum zoom level</li>
<li>disablecontrols - Description: Enables/disables all default UI buttons. May be overridden individually. Does not disable the keyboard controls - Default: false - Allowed values: true or false</li>
<li>force - Description: disable caching of geocoding, only use this on test   - Default: false - Allowed values: true or false</li>
<li>zoomcontrol - Description: display the Zoom +/- buttons  - Default: true - Allowed values: true or false</li>
<li>nozoom - Description: fixes the zoom level by seeting min and max to the starting zoom  - Default: false - Allowed values: true or false</li>
<br>
<li>gesturehandling - Description: This setting controls how the amp handles gestures on the map. - Default: auto - Allowed values:</li>
     <ul><li>"cooperative": Scroll events and one-finger touch gestures scroll the page, and do not zoom or pan the map. Two-finger touch gestures pan and zoom the map. Scroll events with a ctrl key or ⌘ key pressed zoom the map. In this mode the map cooperates with the page.</li>
     <li>"greedy": All touch gestures and scroll events pan or zoom the map.</li>
     <li>"none": The map cannot be panned or zoomed by user gestures.</li>
     <li>"auto": Gesture handling is either cooperative or greedy, depending on whether the page is scrollable or in an iframe.</li></ul>
<li>maptypeid - Description: Determines the initial map display type - Default: roadmap - Allowed values:</li>
     <ul><li>"roadmap": This map type displays a normal street map.</li>
     <li>"satellite": This map type displays satellite images.</li>
     <li>"hybrid": This map type displays a transparent layer of major streets on satellite images.</li>
     <li>"terrain": This map type displays maps with physical features such as terrain and vegetation.</li></ul>



== Frequently Asked Questions ==

=Can I change the width or height of the map?=

Yes, simply supply a width and height parameter:

`[pw_map address="New York City" width="400px" height="200px" key="YOUR API KEY"]`

You can also use percentages for heights:

`[pw_map address="New York City" width="50%" height="200px" key="YOUR API KEY"]`

=Can I disable the scroll wheel?=

Yes, simple add `enablescrollwheel="false"` to the maps shortcode.

`[pw_map address="New York City" enablescrollwheel="false" key="YOUR API KEY"]`

=Can I disable the map controls?=

Yes, simple add `disablecontrols="true"` to the shortcode.

`[pw_map address="New York City" disablecontrols="true" key="YOUR API KEY"]`

=How are the maps cached?=

Maps are cached using the WordPress [Transients API](https://developer.wordpress.org/apis/handbook/transients/), which allows for very efficient and WordPress standard database-based caching.

Each time you display a map, the address specified is used to generate a unique md5 hash, which is used for the cache identifier. This means that if you change the address used for your map, the cache will be refreshed.

For testing ONLY if you want to not use the cache  then specify  force=true

e.g.

`[pw_map address="New York City" force="true" key="YOUR API KEY"]`

=How often do caches refresh?=

The maps are cached for 3 months. Caches are automatically cleared (for individual maps) when you change the address in the shortcode.

=Can I specify multiple pins?=

Yes simply separate addresses with a semi-colon ;  the map will center on the first pin

`[pw_map address="New York City;New Jersey" zoom="8" key="YOUR API KEY"]`

=How do I change the initial zoom?=

Initial zoom can be controlled with the shortcode  option zoom=   the default is zoom=15  use for instance zoom=10 to zoom out

`[pw_map address="New York City" zoom="8" key="YOUR API KEY"]`

=Why do I get REQUEST_DENIED error?=

This is likely to be an issue with the authorization you granted to your API key see [Google API REQUEST_DENIED troubleshooting](https://developers.google.com/maps/documentation/places/web-service/faq#why_do_i_keep_receiving_status_request_denied)

It is recommended that you set an Application Restriction to restrict your API key from others using it.

However restricting the referrer HTTP will cause this error 'API keys with referer restrictions cannot be used with this API', this is because the geoencoding is performed server side and cached server side, so there is no browser referrer.
If you get this message change your restriction to IP addresses  (web servers, cron jobs, etc.) using the IP address of your website.

If you restrict your API key to specific APIs make sure you enable at least
* Maps JavaScript API
* Geocoding API

= Are there any filters for developers? =

For developer documentation on filters visit here [https://fullworksplugins.com/docs/developers-simple-shortcode-for-google-maps/](https://fullworksplugins.com/docs/developers-simple-shortcode-for-google-maps/)

== Installation ==

1. Activate the plugin.
2. Obtain an API key [here](https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key).
3. Added [pw_map address="your address here" key="YOUR API KEY"] to any post or page.

== Changelog ==
= 1.6 =
* escape output to better protect against CSRF ans XSS exploits

= 1.5.4 =
* add filters for developers
* add option to disable zoom
* remove special characters from address that can break Google

[Full Change History](https://plugins.trac.wordpress.org/browser/simple-google-maps-shortcode/trunk/changelog.txt)
