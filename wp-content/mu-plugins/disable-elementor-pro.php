<?php
/**
 * Plugin Name: Disable Elementor Pro (Emergency Fix)
 * Description: Temporarily disables Elementor Pro to prevent fatal errors
 * Version: 1.0
 * Author: Emergency Fix
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Disable Elementor Pro to fix fatal error
add_filter('option_active_plugins', function($plugins) {
    if (!is_array($plugins)) {
        return $plugins;
    }
    
    return array_filter($plugins, function($plugin) {
        // Remove any plugin containing 'elementor-pro'
        return strpos($plugin, 'elementor-pro') === false;
    });
});

// Also disable for network/multisite
add_filter('site_option_active_sitewide_plugins', function($plugins) {
    if (!is_array($plugins)) {
        return $plugins;
    }
    
    $filtered = array();
    foreach ($plugins as $plugin => $time) {
        if (strpos($plugin, 'elementor-pro') === false) {
            $filtered[$plugin] = $time;
        }
    }
    return $filtered;
});

// Add admin notice about the temporary fix
add_action('admin_notices', function() {
    if (current_user_can('manage_options')) {
        echo '<div class="notice notice-warning is-dismissible">';
        echo '<p><strong>Emergency Fix Active:</strong> Elementor Pro has been temporarily disabled due to a fatal error. ';
        echo 'Please reinstall or update Elementor Pro, then delete this file: <code>wp-content/mu-plugins/disable-elementor-pro.php</code></p>';
        echo '</div>';
    }
});