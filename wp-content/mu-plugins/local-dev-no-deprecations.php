<?php
/**
 * Plugin Name: Local Dev: Hide Deprecations and Notices
 * Description: In local development, keeps WP_DEBUG logging on, but suppresses display of deprecations and doing_it_wrong notices.
 */

if ( defined('LOCAL_DEV') && LOCAL_DEV ) {
    // Ensure logs are captured but not displayed.
    if ( defined('WP_DEBUG') && WP_DEBUG ) {
        if ( ! defined('WP_DEBUG_DISPLAY') ) {
            define( 'WP_DEBUG_DISPLAY', false );
        }
        if ( ! defined('WP_DEBUG_LOG') ) {
            define( 'WP_DEBUG_LOG', true );
        }
    }

    // Suppress WordPress deprecation/doing-it-wrong triggers.
    add_filter( 'deprecated_function_trigger_error', '__return_false', 9999 );
    add_filter( 'deprecated_argument_trigger_error', '__return_false', 9999 );
    add_filter( 'deprecated_file_trigger_error', '__return_false', 9999 );
    add_filter( 'doing_it_wrong_trigger_error', '__return_false', 9999 );

    // Leave PHP error_reporting as-is so deprecations still get logged when WP_DEBUG_LOG is true.
}
