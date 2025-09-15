<?php
/**
 * Plugin Name: Local Dev: Enforce HTTP (no HTTPS) and prevent https redirects
 * Description: For local development with PHP's built-in server, force http:// URLs and strip any https redirects to avoid TLS handshake failures.
 */

if ( defined('LOCAL_DEV') && LOCAL_DEV ) {
    // Ensure WordPress core URL getters use http scheme.
    add_filter('option_home', function ($value) {
        return preg_replace('/^https:/i', 'http:', $value);
    });
    add_filter('option_siteurl', function ($value) {
        return preg_replace('/^https:/i', 'http:', $value);
    });

    $force_http = function ($url) {
        if (!is_string($url)) return $url;
        // Downgrade any https to http for local dev.
        return preg_replace('/^https:/i', 'http:', $url);
    };

    add_filter('home_url', $force_http, 9999);
    add_filter('site_url', $force_http, 9999);
    add_filter('content_url', $force_http, 9999);
    add_filter('plugins_url', $force_http, 9999);
    add_filter('includes_url', $force_http, 9999);
    add_filter('rest_url', $force_http, 9999);

    // Prevent plugins/core from forcing https redirects.
    add_filter('wp_redirect', function ($location, $status) use ($force_http) {
        return $force_http($location);
    }, 9999, 2);

    // WooCommerce: ensure SSL checkout is off locally.
    add_filter('woocommerce_force_ssl_checkout', '__return_false', 9999);
}
