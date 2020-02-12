<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.chrissteurer.com
 * @since      1.0.0
 *
 * @package    Plugins_rss_feed
 * @subpackage Plugins_rss_feed/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Plugins_rss_feed
 * @subpackage Plugins_rss_feed/includes
 * @author     Chris Steurer <stoypenny@gmail.com>
 */
class Plugins_rss_feed_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'plugins_rss_feed',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
