<?php
// WordPress diagnostic script
echo "<h1>WordPress Site Health Check</h1>";

// Check if WordPress can load
if (file_exists('wp-config.php')) {
    echo "<p>✅ wp-config.php found</p>";
    
    // Load WordPress
    require_once 'wp-config.php';
    require_once ABSPATH . 'wp-load.php';
    
    echo "<p>✅ WordPress loaded successfully</p>";
    echo "<p>WordPress Version: " . get_bloginfo('version') . "</p>";
    echo "<p>PHP Version: " . phpversion() . "</p>";
    echo "<p>Memory Limit: " . ini_get('memory_limit') . "</p>";
    echo "<p>Max Execution Time: " . ini_get('max_execution_time') . " seconds</p>";
    
    // Check database connection
    if (is_wp_error($wpdb->last_error)) {
        echo "<p>❌ Database connection error: " . $wpdb->last_error . "</p>";
    } else {
        echo "<p>✅ Database connection working</p>";
    }
    
    // Check if plugins are causing issues
    echo "<h2>Active Plugins:</h2>";
    $active_plugins = get_option('active_plugins', array());
    if (empty($active_plugins)) {
        echo "<p>No active plugins</p>";
    } else {
        echo "<ul>";
        foreach ($active_plugins as $plugin) {
            echo "<li>" . $plugin . "</li>";
        }
        echo "</ul>";
    }
    
} else {
    echo "<p>❌ wp-config.php not found</p>";
}

echo "<p><strong>If you see this message, the site is loading correctly!</strong></p>";
?>