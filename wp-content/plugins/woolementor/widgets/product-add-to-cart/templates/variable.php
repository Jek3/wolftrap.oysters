<?php

add_filter( 'woocommerce_product_single_add_to_cart_text', function( $defaults ) use ( $button_text ) {
	$defaults = $button_text;
	return $defaults;
} );

$the_product = $product;
global $product;

if ( is_string( $product ) ) {
	$product = $the_product;
}

woocommerce_variable_add_to_cart();

