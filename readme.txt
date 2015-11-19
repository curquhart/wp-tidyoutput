=== Tidy Output ===
Contributors: curquhart
Tags: formatting, cleanup, html sanitization
Requires at least: 3.0.1
Tested up to: 4.4
Stable tag: v1.0.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Tidy Output is a plugin designed to cleanup and/or format output HTML.

== Description ==

Tidy Output formats and/or cleans up output HTML based on the configured settings.
It supports Tidy (PHP library) and DOMDocument for cleanup. Only Tidy is supported
for formatting.

Additionally, it is possible to indent all of the post content to a certain
level in order to make it line up properly with the rest of the output. This is
not necessary when formatting the whole page, however.

Spanish and French translations are included and I'm more than happy to include
others on request (or improve the existing ones -- I only speak English so they
are probably not the most accurate translations.)

== Installation ==

1. Upload `tidyoutput` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Visit `/wp-admin/options-general.php?page=tidyoutput` to configure the plugin.
Note that the default options are probably sufficient (just cleanup bad post content)

== Screenshots ==

1. This is the settings page (with default settings)

== Changelog ==

= 1.0.1 =
* Fixed uninstall
* Updates screenshot

= 1.0 =
* First release
