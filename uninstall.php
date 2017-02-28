<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * @since       1.0.0
 * @package     DmvContactForm
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'dmv_name' );
delete_option( 'dmv_email' );
delete_option( 'dmv_subject' );
delete_option( 'dmv_message' );
delete_option( 'dmv_success_message' );