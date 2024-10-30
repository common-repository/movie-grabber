=== Movie Grabber ===
Contributors: moviegrabber
Tags: movie, grabber, imdb, scraper, bot, film
Donate Links: 1PXWBbzf54LkA6PN9qGTVj1jkzDZFuxj4k (BTC) -- 0xD627396bd6b1eAC0f30C5FdE3B6f4F225c31572C (ETH) -- qzxqun9jvn8fddgzytrdz7fmduzphx4llqtfnu05ue (BCH)
Requires at least: 4.x
Tested up to: 4.9.6
Stable tag: 4.9.7
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==

A great plugin to you. If you want to open a movie website, you can have a movie website with a quality information pool from two different sources and imdb. Try it now!

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin files to the `/wp-content/plugins/smmg-movie-grabber` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings->Movie Grabber screen to configure the plugin
4. It's done!


== Frequently Asked Questions ==

1. How can I show the duration custom field in my theme?

get_post_meta($post->ID, "duration", true);

2. How can I show the director custom field in my theme?

get_post_meta($post->ID, "director", true);

3. How can I show the writer custom field in my theme?

get_post_meta($post->ID, "writer", true);

4. How can I show the stars custom field in my theme?

get_post_meta($post->ID, "stars", true);

2. How can I show the genre custom field in my theme?

get_post_meta($post->ID, "genre", true);

2. How can I show the country custom field in my theme?

get_post_meta($post->ID, "country", true);

2. How can I show the rating custom field in my theme?

get_post_meta($post->ID, "rating", true);

2. How can I show the thumbnail custom field in my theme?

get_post_meta($post->ID, "thumbnail", true);

== Screenshots ==

1. screenshot-1.png
2. screenshot-2.png

== Changelog ==

No commit

== Upgrade Notice ==