<?php

/*
 * This file is part of the Sim Site Maintenance plugin.
 *
 * The full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require \dirname(__FILE__, 2) . '/vendor/autoload.php';
require \dirname(__FILE__, 2) . '/vendor/szepeviktor/phpstan-wordpress/bootstrap.php';
require \dirname(__FILE__, 2) . '/tests/stubs.php';

// -----------------------------------------------------------------------------
// Define basic WordPress constants for compatibility in testing environments.
// Reference: https://developer.wordpress.org/reference/
// -----------------------------------------------------------------------------

if ( ! \defined('HOUR_IN_SECONDS')) {
    \define('HOUR_IN_SECONDS', 3600);
}

if ( ! \defined('DAY_IN_SECONDS')) {
    \define('DAY_IN_SECONDS', 86400);
}

if ( ! \defined('WEEK_IN_SECONDS')) {
    \define('WEEK_IN_SECONDS', 604800);
}

if ( ! \defined('MONTH_IN_SECONDS')) {
    \define('MONTH_IN_SECONDS', 2592000); // Approx. 30 days.
}

if ( ! \defined('YEAR_IN_SECONDS')) {
    \define('YEAR_IN_SECONDS', 31536000);
}

if ( ! \defined('ABSPATH')) {
    \define('ABSPATH', '/tmp/wordpress/');
}

// -----------------------------------------------------------------------------
// Additional constants helpful for plugin and theme testing.
// These mimic real WordPress behavior but are safe defaults.
// -----------------------------------------------------------------------------

if ( ! \defined('WP_CONTENT_DIR')) {
    \define('WP_CONTENT_DIR', ABSPATH . 'wp-content');
    // Docs: https://developer.wordpress.org/reference/constant/wp_content_dir/
}

if ( ! \defined('WP_PLUGIN_DIR')) {
    \define('WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins');
    // Docs: https://developer.wordpress.org/reference/constant/wp_plugin_dir/
}

if ( ! \defined('WP_DEBUG')) {
    \define('WP_DEBUG', true);
    // Docs: https://developer.wordpress.org/reference/constant/wp_debug/
}

if ( ! \defined('WP_ENVIRONMENT_TYPE')) {
    \define('WP_ENVIRONMENT_TYPE', 'development');
    // Docs: https://developer.wordpress.org/apis/wp-config-php/#environment-type
}

if ( ! \defined('WP_MEMORY_LIMIT')) {
    \define('WP_MEMORY_LIMIT', '128M');
    // Docs: https://developer.wordpress.org/reference/constant/wp_memory_limit/
}
