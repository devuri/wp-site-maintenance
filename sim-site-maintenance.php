<?php
/**
 * @wordpress-plugin
 * Plugin Name:        Sim Site Maintenance
 * Plugin URI:        https://urielwilson.com/
 * Description:       Puts the site in maintenance mode for all non-logged-in users.
 * Version:           0.2.11
 * Requires at least: 4.0
 * Requires PHP:      7.3
 * Author:            uriel
 * Author URI:        https://urielwilson.com
 * Text Domain:       sim-site-maintenance
 * License:           GPLv2
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// start plugin.
if ( ! \defined( 'ABSPATH' ) ) {
    exit;
}

// Load composer.
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

// The plugin.
SimSiteMaintenance\Plugin::init()->hooks();
