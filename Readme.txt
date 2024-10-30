=== La Tecnologeria Podcasting players ===
Contributors: tecnologeria
Donate link: https://tecnologeria.com
Tags: podcast, podcasting, audio, mp3
Requires at least: 4.9.13
Tested up to: 5.8.2
Requires PHP: 5.6.40
Stable tag: 1.3
License: LGPLv3
License URI: http://www.gnu.org/licenses/lgpl-3.0.html

A plugin to add external players easily in your web using shortcodes.

== Description ==

Use easy-to-use shortcodes in your posts or pages to display audio players from different platforms.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin files to the `/wp-content/plugins/tecnologeria-podcasting` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress


== Frequently Asked Questions ==

= What if I make a mistake in the shortcode format? =

An error message will be shown in your post. The message should guide you to repair the shortcode syntax. Try previewing your posts before publishing them!

= What will be shown if everything is ok? =

An <iframe> element that contains the player should be shown if everything is right.


== Changelog ==
= 1.3 =
* [ivoox-program] shortcode added to show all the episodes in an iVoox program (see [iVoox web](https://blog.ivoox.com/nuevo-widget-de-podcast-usalo-para-crecer-en-audiencia_0078219/), in Spanish).
* [ivoox] shortcode now supports color attribute.

= 1.2.1 =
* [youtube] shortcode now supports privacy-enhance mode

= 1.2 =
* new iVoox widget added via 'ivoox' shortcode. If you aim to keep old ivoox shortcode in your website, please use 'ivoox-old' shortcode instead.

= 1.1 =
* Youtube shortcode added.

= 1.0 =
* First stable version.

== Upgrade Notice ==
= 1.1 =
[youtube] shortcode added.

== How to use this plugin ==

This plugin offers several shortcodes to integrate different podcasting platforms in your website. In this version we support Youtube and iVoox platforms.

= iVoox(TM) shortcodes =

There are two kinds of iVoox widgets: episode and program widgets.

For **episode widgets**, you need the episode id, which can be taken from the URL from your published episode. Use this id as follows:

`[ivoox id="49097143"]`
`[ivoox id="49097143" color="#00EACD"]`

These are the fields that must be provided with the shortcode:
* `id` (mandatory) field should be the identifier in the episode URL (a number).
* `color` (optional) field is the color that substitutes the default color. In HTML format (#RRGGBB). Remember to include the #. A default color can be provided in the plugin settings page. It would be used unless this field is explicitly provided.

In case you want to keep on using the old player, use the following shortcode:

`[ivoox-old id="49097143" color="#00EACD"]`

Compact and mini versions of the episode player can also be used instead:

`[ivoox-compact id="49097143"]`
`[ivoox-mini id="49097143"]`

Color configuration is not available for these versions of the player.

If you aim to use **program widgets**, use the following shortcode:
`[ivoox-program id="313872" color="#00EACD"]`

These are the fields that must be provided with the shortcode:
* `id` (mandatory) field should be the identifier in the podcast URL (a number).
* `color` (optional) field is the color that substitutes the default color. In HTML format (#RRGGBB). Remember to include the #. A default color can be provided in the plugin settings page. It would be used unless this field is explicitly provided.

= Youtube shortcode =

Integrate a Youtube video using its ID. Use the shortcode as follows:

`[youtube id="jmZ5Pf5j0A8" width=“800” height="450" cookies="no"]`

These are the fields that can be used with the shortcode:
* `id` (mandatory) field must be the identifier of the video that can be taken from the video URL.
* `width` (optional) field would be the width of the player.
* `height` (optional) field would be the height of the player.
* `cookies`(optional) field to use privacy-enhance mode (check [Youtube website](https://support.google.com/youtube/answer/171780?visit_id=637478635883120886-287002157&rd=1#zippy=%2Cturn-on-privacy-enhanced-mode)).

If width and height are not specified, default values are 560x315. If only one of them is specified, the remaining dimension is computed using 16:9 proportion.

Cookies option is boolean. Use values true/on/yes/1 to use the standard player or false/off/no/0 to enable the enhanced mode. Enhanced mode is the default option in case it is not specified.

= Other platforms =

They're about to come in upcoming versions.

== Screenshots ==

1. Use iVoox(TM) shortcodes in your posts or pages!!