<?php

/**
 *	Plugin Name: Wordphonic
 *	Plugin URI: http://tracyfu.com/wordphonic
 *	Description: Play MP3s on WordPress with the stylish and fully-customizable E-Phonic Flash MP3 Player!
 *	Version: 1.0.0
 *	Author: Tracy Fu
 */

/**
 *	Copyright 2008 Tracy Fu (email : wordphonic@tracyfu.com)
 *
 *	This program is free software; you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation; either version 2 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program; if not, write to the Free Software
 *	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

// Path to PLAYLIST.XML
define('PLAYLIST_XML_PATH', 'playlist.xml');

// Determine Installation Path & URL
$path = basename(str_replace('\\','/',dirname(__FILE__)));
$info['siteurl'] = get_option('siteurl');
$info['install_url'] = $info['siteurl'] . '/wp-content/plugins';
$info['install_dir'] = ABSPATH . 'wp-content/plugins';
if ( $path != 'plugins' ) {
	$info['install_url'] .= '/' . $path;
	$info['install_dir'] .= '/' . $path;
}

// Initialize Wordphonic
function install_wordphonic() {
	global $info;
	update_option('ephonic_init', 1);
	
	// Set Defaults
	update_option('ephonic_skin', 'nobius_platinum');
	update_option('ephonic_autoplay', 0);
	update_option('ephonic_shuffle', 0);
	update_option('ephonic_repeat', 1);
	update_option('ephonic_buffer_time', 1);
	update_option('ephonic_volume', 75);
	update_option('ephonic_mute', 0);
	update_option('ephonic_reg_key', "");
	
	// Set Demo Playlist
	$demo = array('artist' => 'E-Phonic', 
				  'title'  => 'MP3 Player!',
				  'file'   => "$info[install_url]/ephonic/mp3/demo.mp3",
				  'image'  => "$info[install_url]/ephonic/mp3/demo.jpg");

	update_option('t1', $demo);
	
	for ( $i = 2; $i < 11; $i++ ) {
		update_option('t' . $i, array('artist' => '', 'title' => '', 'file' => '', 'image' => ''));
	}
	
	// Write Playlist XML
	if ( file_get_contents(PLAYLIST_XML_PATH) == '' ) {
		write_playlist();
	}
}

// Write Playlist XML
function write_playlist() {
	$tracks_xml = '';
	
	for ( $i = 1; $i < 16; $i++ ) {
		$track = get_option('t' . $i);
		
		if ( $track['file'] != '' ) {
			$tracks_xml .= '<track>';
			$tracks_xml .= '<location>' . $track['file'] . '</location>';
			$tracks_xml .= '<title>' . $track['title'] . '</title>';
			$tracks_xml .= '<creator>' . $track['artist'] . '</creator>';
			$tracks_xml .= '<image>' . $track['image'] . '</image>';
			$tracks_xml .= '</track>';
		}
	}

	$playlist_xml = '<?xml version="1.0" encoding="UTF-8"?><playlist version="1" xmlns = "http://xspf.org/ns/0/"><trackList>' . $tracks_xml . '</trackList></playlist>';
	
	// Using 'fwrite' for PHP < 5 compatibility
	if ( is_writable(PLAYLIST_XML_PATH) ) {
		// TODO: Write logic in case file isn't writable
		if ( !$handle = fopen(PLAYLIST_XML_PATH, 'w') ) exit;
		if ( fwrite($handle, $playlist_xml) === FALSE ) exit;
		fclose($handle);
	}
}

// First Run
if ( !get_option('ephonic_init') ) {
	add_action('init', 'install_wordphonic');
}

// Write 'swfobject' to Head
function write_js_to_head() {
	global $info;
	echo '<script src="' . $info['install_url'] . '/ephonic/swfobject.js" type="text/javascript"></script>';
}

add_action('admin_head', 'write_js_to_head');
add_action('wp_head', 'write_js_to_head');

// Add the Wordphonic Admin Panel
include_once($info['install_dir'] . '/options.php');

function add_admin_panel () {
	add_options_page('Wordphonic Plugin Options', 'Wordphonic', 7, 'index.php', 'create_admin_panel');
}

add_action('admin_menu', 'add_admin_panel');

// Write Playlist at Shutdown

add_action('shutdown', 'write_playlist');

?>