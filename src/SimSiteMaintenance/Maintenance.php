<?php
/**
 * This file is part of the Site MaintenanceWordPress PLugin.
 *
 * (c) Uriel Wilson <hello@urielwilson.com>
 *
 * Please see the LICENSE file that was distributed with this source code
 * for full copyright and license information.
 */

namespace SimSiteMaintenance;

class Maintenance
{
    private $custom_page_id;

    public function __construct()
    {
		// TODO add settings for custom page ID.
        $this->custom_page_id = get_option('simsitemaintenance_custom_page_id');
    }

    /**
     * Check and display the maintenance page if maintenance mode is enabled.
     *
     * @return void
     */
    public function page(): void
    {
        if ($this->is_login_or_register_page()) {
            return;
        }

        if ($this->is_maintenance_enabled() && !$this->can_bypass_maintenance()) {
            $this->display_maintenance_page();
        }
    }

    /**
     * Check if the current page is login or register page.
     *
     * @return bool
     */
    private function is_login_or_register_page(): bool
    {
        return in_array($GLOBALS['pagenow'], ['wp-login.php', 'wp-register.php'], true);
    }

    /**
     * Check if maintenance mode is enabled.
     *
     * @return bool
     */
    private function is_maintenance_enabled(): bool
    {
        return get_option('simsitemaintenance_enabled', false);
    }

    /**
     * Check if the user can bypass the maintenance mode.
     *
     * @return bool
     */
    private function can_bypass_maintenance(): bool
    {
        return current_user_can('edit_themes') && is_user_logged_in();
    }

    /**
     * Display the maintenance page and halt further script execution.
     *
     * @return void
     */
    private function display_maintenance_page(): void
    {
        if ($this->custom_page_id && get_post_status($this->custom_page_id)) {
            echo apply_filters('the_content', get_post_field('post_content', $this->custom_page_id));
        } else {
            // Default maintenance message and header
            $message = get_option('simsitemaintenance_message', 'We are currently performing maintenance. Please check back later.');
            $header  = get_option('simsitemaintenance_header', 'Under Maintenance');

            header('Retry-After: 3600');
            wp_die(
                '<h1>' . esc_html($header) . '</h1><p>' . esc_html($message) . '</p>',
                esc_html($header),
                ['response' => 503]
            );
        }
        exit; // Ensure no further output is sent
    }
}
