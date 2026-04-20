<?php
/**
 * Sim Site Maintenance uninstall routine.
 *
 * Called automatically by WordPress when the plugin is deleted from the
 * Plugins screen. Drops all three Wisp tables and removes all Wisp options.
 *
 * @package SimSiteMaintenance
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}
