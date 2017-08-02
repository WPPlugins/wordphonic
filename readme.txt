=== Wordphonic ===
Contributors: tracyfu
Donate link: http://tracyfu.com/wordphonic/#download
Tags: mp3, flash, player, music, playlist
Requires at least: 2.3
Tested up to: 2.3
Stable tag: trunk

Play MP3s on WordPress with the stylish and fully-customizable E-Phonic Flash MP3 Player.

== Description ==

Play MP3s on WordPress with the stylish and fully-customizable E-Phonic Flash MP3 Player. Manage custom settings, add your playlist and sample a live preview directly within the Wordphonic admin panel!

== Installation ==

Please follow these instructions to install Wordphonic:

1. Download the zipped plugin.
2. Unzip the archive and upload the 'wordphonic' folder to your WordPress Plugins folder (/wp-content/plugins/).
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Go to your Wordphonic Admin Panel (Options > Wordphonic) to get started!

Enjoi.

== Frequently Asked Questions ==

= Where do I place the code? =

You can paste the code in any template or post, provided that your theme contains the 'wp_head();' hook within the document head.

= The player isn't showing up. I'm getting an error asking me to upgrade my Flash Player, but I know Flash is properly installed. What do I do? =

1. If you pasted the code into a post, make sure you pasted it into the 'Code' view.
2. Or, if the error occurred after you pasted the code into a post, and later returned to edit the post, try re-pasting the code.

= The player is giving me the error 'Error Loading MP3'. What do I do? =

When in doubt, use absolute paths to your MP3s when listing MP3 Locations in the admin panel. Relative paths are local to your WordPress blog, not your WordPress installation.

= How can I add more than one player on a page? =

For each new player you want to add, change the following code:

1. Change the 'id' in the first line '<div id="flashcontent">' to another unique id. This can be anything, but it must start with a letter and can contain only alphanumeric characters, '-' and '_'.

2. Change the 'id' in the line 'so.write("flashcontent");' to the same id you chose in step 1.

== History ==

* Version 1.0
	* Initial Release!