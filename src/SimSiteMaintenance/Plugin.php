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

use Urisoft\AbstractPlugin;

class Plugin extends AbstractPlugin
{
    public function hooks(): void
    {
        add_action( 'init', [ $this, 'maintenance_mode' ] );
        add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
        add_action( 'admin_init', [ $this, 'settings_init' ] );
    }

    public function maintenance_mode(): void
    {
        $is_login_register_page = \in_array( $GLOBALS['pagenow'], [ 'wp-login.php', 'wp-register.php' ], true );

        if ( $is_login_register_page ) {
            return;
        }

        $enabled = get_option( 'smm_enabled', false );

        if ( $enabled && ( ! current_user_can( 'edit_themes' ) || ! is_user_logged_in() ) ) {
            $message = get_option( 'smm_message', 'We are currently performing maintenance. Please check back later.' );
            $header  = get_option( 'smm_header', 'Under Maintenance' );

            header( 'Retry-After: 3600' );
            wp_die(
                '<h1>' . esc_html( $header ) . '</h1><p>' . esc_html( $message ) . '</p>',
                esc_html( $header ),
                [ 'response' => 503 ]
            );
        }
    }

    public function add_admin_menu(): void
    {
        add_options_page( 'Simple Maintenance Mode', 'Maintenance Mode', 'manage_options', 'simple-maintenance-mode', [ $this, 'options_page' ] );
    }

    public function settings_init(): void
    {
        register_setting( 'smm_settings', 'smm_enabled' );
        register_setting( 'smm_settings', 'smm_message' );
        register_setting( 'smm_settings', 'smm_header' );

        add_settings_section(
            'smm_section',
            __( 'Simple Maintenance Mode Settings', 'site-maintenance' ),
            [ $this, 'settings_section_callback' ],
            'smm_settings'
        );

        add_settings_field(
            'smm_enabled',
            __( 'Enable Maintenance Mode', 'site-maintenance' ),
            [ $this, 'enabled_render' ],
            'smm_settings',
            'smm_section'
        );

        add_settings_field(
            'smm_header',
            __( 'Maintenance Header', 'site-maintenance' ),
            [ $this, 'header_render' ],
            'smm_settings',
            'smm_section'
        );

        add_settings_field(
            'smm_message',
            __( 'Maintenance Message', 'site-maintenance' ),
            [ $this, 'message_render' ],
            'smm_settings',
            'smm_section'
        );
    }

    public function enabled_render(): void
    {
        $enabled = get_option( 'smm_enabled', false );
        ?>
	        <input type="checkbox" name="smm_enabled" value="1" <?php checked( $enabled, 1 ); ?>>
	        <?php
    }

    public function header_render(): void
    {
        $header = get_option( 'smm_header', 'Under Maintenance' );
        ?>
	        <input type="text" name="smm_header" value="<?php echo esc_attr( $header ); ?>" size="50">
	        <?php
    }

    public function message_render(): void
    {
        $message = get_option( 'smm_message', 'We are currently performing maintenance. Please check back later.' );
        ?>
	        <textarea name="smm_message" rows="5" cols="50"><?php echo esc_textarea( $message ); ?></textarea>
	        <?php
    }

    public function settings_section_callback(): void
    {
        echo __( 'Customize the maintenance mode settings.', 'site-maintenance' );
    }

    public function options_page(): void
    {
        ?>
	        <form action="options.php" method="post">
	            <h2>Simple Maintenance Mode</h2>
	            <?php
				settings_fields( 'smm_settings' );
				do_settings_sections( 'smm_settings' );
				submit_button();
				?>
	        </form>
	        <?php
    }
}
