<?php
/*
Plugin Name:    R3DF - Multisite Blog Slug Remover
Description:    Remove '/blog' from WordPress multisite main site blog permalinks.
Plugin URI:     http://r3df.com/
Version:        1.0.0
Network:        true
Text Domain:    r3df-mbsr
Domain Path: 	/lang/
Author:         R3DF
Author URI:     http://r3df.com
Author email:   plugin-support@r3df.com
Copyright:      R-Cubed Design Forge
*/

/*  Copyright 2012-2015 R-Cubed Design Forge

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//avoid direct calls to this file where wp core files not present
if ( ! function_exists( 'add_action' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( function_exists( 'is_multisite' ) && is_multisite() ) {
	new R3DF_Multisite_Blog_Slug_Remover();
}

/**
 * Class R3DF_Multisite_Blog_Slug_Remover
 *
 */
class R3DF_Multisite_Blog_Slug_Remover {
	private $options = array( 'category_base', 'tag_base', 'permalink_structure' );

	/**
	 * Class constructor
	 *
	 */
	function __construct() {
		if ( ! is_admin() ) {
			return;
		}

		if ( is_main_site() ) {
			register_activation_hook( plugin_basename( __FILE__ ), array( &$this, 'activate' ) );
			register_deactivation_hook( plugin_basename( __FILE__ ), array( &$this, 'deactivate' ) );

			// strip blog from permalinks if it's there, and flush rewrite
			add_action( 'admin_init', array( $this, 'remove_blog_slug_init' ) );

			// Filter /blog from main permalink, category base and tag base upon option update to database
			// Options are saved when options-permalinks.php is saved - options-permalinks.php re-includes the '/blog'
			foreach ( $this->options as $option_tag ) {
				add_filter( 'pre_update_option_' . $option_tag, array( $this, 'remove_blog_slug_filter' ) );
			}

			// Remove '/blog' from options page display
			//add_action( 'load-options-permalink.php', array( $this, 'start_options_capture' ) );
			add_action( 'in_admin_header', array( $this, 'start_options_capture' ) );
		}
	}


	/**
	 * Get and save permalink options to remove the '/blog' automatically
	 *
	 */
	function remove_blog_slug_init() {
		global $wp_rewrite;

		$flush_rewrite = false;
		foreach ( $this->options as $option_tag ) {
			$option = get_option( $option_tag );
			if ( '/blog/' == substr( $option, 0, 6 ) ) {
				// saving will remove '/blog' with the filters set above.
				update_option( $option_tag, $option );
				// check if option changed, invoke rewrite if yes
				if ( '/blog/' != substr( get_option( $option_tag ), 0, 6 ) ) {
					$flush_rewrite = true;
				}
			}
		}

		if ( $flush_rewrite ) {
			$wp_rewrite->set_permalink_structure( get_option( 'permalink_structure' ) );
			$wp_rewrite->flush_rules();
		}

		return;
	}

	/**
	 * Strip '/blog' from options after options page save (or any other save)
	 * Called any time the permalink options are saved.
	 *
	 * @param $option
	 *
	 * @return string
	 *
	 */
	function remove_blog_slug_filter( $option ) {
		// if permalink starts with /blog/, remove it
		if ( '/blog/' == substr( $option, 0, 6 ) ) {
			$option = substr( $option, 5 );
		}
		return $option;
	}

	/**
	 * Start capture of options page display - lets us remove '/blog' later
	 *
	 */
	function start_options_capture() {
		// need to check screen, load-options-permalink.php seems to get called in network admin (plugins page at least)
		if ( function_exists( 'get_current_screen' ) ) {
			$screen = get_current_screen();
			if ( ! empty( $screen ) && 'options-permalink' == $screen->id ) {
				ob_start();
				add_action( 'in_admin_footer', array( $this, 'remove_blog_slug_in_options' ) );
			}
		}
	}

	/**
	 * Remove '/blog' from options page display, it's hard coded in the prefix display in options-permalinks.php
	 *
	 */
	function remove_blog_slug_in_options() {
		if ( '/blog/' != substr( get_option( 'permalink_structure' ), 0, 6 ) ) {
			echo str_replace( '/blog', '', ob_get_clean() );
		} else {
			echo ob_get_clean();
		}
	}

	/**
	 * Activate - remove '/blog' from default settings
	 *
	 */
	function activate() {
		if ( ! is_admin() ) {
			return;
		}

		// switch to main site if we are not on it
		if ( ! is_main_site() ) {
			switch_to_blog( 1 );
		}

		$this->remove_blog_slug_init();

		// switch back to current site if we were not on main
		restore_current_blog();
	}

	/**
	 * Deactivate - add '/blog' back to permalinks
	 *
	 */
	function deactivate() {
		global $wp_rewrite;

		if ( ! is_admin() ) {
			return;
		}

		// switch to main site if we are not on it
		if ( ! is_main_site() ) {
			switch_to_blog( 1 );
		}

		// remove '/blog' filters set above, so we can put '/blog' back
		foreach ( $this->options as $option_tag ) {
			remove_filter( 'pre_update_option_' . $option_tag, array( $this, 'remove_blog_slug_filter' ) );
		}

		// put '/blog' back
		foreach ( $this->options as $option_tag ) {
			$option = get_option( $option_tag );
			if ( ! empty( $option ) ) {
				if ( '/' == substr( $option, 0, 1 ) ) {
					update_option( $option_tag, '/blog' . $option );
				} else {
					update_option( $option_tag, '/blog/' . $option );
				}
			}
		}

		// flush rewrite to reset permalinks
		$wp_rewrite->set_permalink_structure( get_option( 'permalink_structure' ) );
		$wp_rewrite->flush_rules();

		// switch back to current site if we were not on main
		restore_current_blog();
	}
}
