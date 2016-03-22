=== R3DF Multisite Blog Slug Remover ===
Contributors: r3df
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=MX3FLF4YGXRLE
Tags: blog slug, blog, slug, permalink, permalinks, url, multi-site, multisite, network, remove, remover
Stable tag: 1.0.0
Requires at least: 4.1
Tested up to: 4.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Removes the '/blog' slug from the main site permalinks in a multisite.

== Description ==

This plugin removes the '/blog' slug from the main site permalinks of a sub-folder multisite install. The intended purpose for this plugin
is for multilingual installations where the main site is the default language (although I'm sure there are other applications).  These sites
are of often for businesses where having the '/blog' in the permalink (URL) does not make sense.

'/blog' is automatically removed from the main site permalinks upon plugin activation.

'/blog' is automatically restored in permalinks upon plugin deactivation.

== Installation ==

= The easy way: =
1. To install this plugin, click on "Add New" on the plugins page in your WordPress dashboard.
1. Search for "R3DF Multisite Blog Slug Remover", click install when it's found.
1. **Network activate** the plugin through the 'Plugins' menu in Network Admin in WordPress. (The plugin only acts on the main site, and Network activation hides it from the other sites)

= The hard way: =
1. Download the latest r3df-multisite-blog-slug-remover.zip from wordpress.org
1. Upload r3df-blog-slug-remover.zip to the `/wp-content/plugins/` folder on your web server
1. Uncompress r3df-multisite-blog-slug-remover.zip (delete r3df-multisite-blog-slug-remover.zip after it's uncompressed)
1. **Network activate** the plugin through the 'Plugins' menu in Network Admin in WordPress. (The plugin only acts on the main site, and Network activation hides it from the other sites)

== Changelog ==

= Version 1.0.0 =
* Initial release

== Upgrade Notice ==
= 1.0.0 =
* Initial release