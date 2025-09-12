<?php
/**
 * Plugin Name: Shipping Discount for WooCommerce
 * Plugin URI: https://1teamsoftware.com/product/woocommerce-shipping-discount/
 * Description: Applies discount to shipping rates based on the rules
 * Tested up to: 5.6
 * WC requires at least: 3.2
 * WC tested up to: 4.7
 * Version: 1.0.8
 * Author: OneTeamSoftware
 * Author URI: http://oneteamsoftware.com/
 * Developer: OneTeamSoftware
 * Developer URI: http://oneteamsoftware.com/
 * Text Domain: wc-shipping-discount
 * Domain Path: /languages
 *
 * Copyright: © 2020 FlexRC, 3-7170 Ash Cres, V6P 3K7, Canada. Voice 604 800-7879 
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace OneTeamSoftware\Woocommerce\ShippingDiscount;

if (!defined('ABSPATH')) { 
    exit; // Exit if accessed directly
}

/**
 * Check if WooCommerce is active
 **/
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    include_once 'includes/ShippingDiscount.php';
}

