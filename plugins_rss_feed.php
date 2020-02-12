<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.chrissteurer.com
 * @since             1.0.0
 * @package           Plugins_rss_feed
 *
 * @wordpress-plugin
 * Plugin Name:       Site Plugins RSS Feed
 * Plugin URI:        https://www.chrissteurer.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Chris Steurer
 * Author URI:        https://www.chrissteurer.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       plugins_rss_feed
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGINS_RSS_FEED_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugins_rss_feed-activator.php
 */
function activate_plugins_rss_feed() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugins_rss_feed-activator.php';
	Plugins_rss_feed_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugins_rss_feed-deactivator.php
 */
function deactivate_plugins_rss_feed() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-plugins_rss_feed-deactivator.php';
	Plugins_rss_feed_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugins_rss_feed' );
register_deactivation_hook( __FILE__, 'deactivate_plugins_rss_feed' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-plugins_rss_feed.php';

/**
 * Create an RSS Feed of Active Plugins
 */
function customRSS() {
    add_feed('active_plugins', 'createPluginRssFeed');
}

/**
 * Create RSS Header
 */
function my_custom_rss_content_type( $content_type, $type ) {
	/* Filter the type, this hook wil set the correct HTTP header for Content-type. */
	if ( 'active_plugins' === $type ) {
		return feed_content_type( 'rss2' );
	}
	return $content_type;
}

/**
 * Get RSS Content
 */
function createPluginRssFeed() {
	// Get the RSS Feed Content
    require_once plugin_dir_path( __FILE__ ) . 'includes/plugins-rss-feed.php';
}

/**
 * Authenticate The RSS Feeds
 */
function authenticateRSS() {
    if (!isset($_SERVER['PHP_AUTH_USER'])) {
        header('WWW-Authenticate: Basic realm="RSS Feeds"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Feeds from this site are private';
        exit;
    } else {
        if (is_wp_error(wp_authenticate($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW']))) {
            header('WWW-Authenticate: Basic realm="RSS Feeds"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Username and password were not correct';
            exit;
        }
    }
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugins_rss_feed() {

	$plugin = new Plugins_rss_feed();
	$plugin->run();

	add_action( 'init', 'customRSS' );
	add_filter( 'feed_content_type', 'authenticateRSS', 10, 2 );
	add_action( 'customRSS', 'my_check_feed_auth', 1 );

}
run_plugins_rss_feed();