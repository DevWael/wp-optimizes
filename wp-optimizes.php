<?php
/**
 * Plugin Name: WP Optimizes
 * Description: Disable wp cron - reduce ajax requests - disable wp heartbeat.
 * Version: 1.0
 * Author: Ahmad Wael
 * Author URI: https://github.com/devwael
 * License: GPLv2
 */

include plugin_dir_path( __FILE__ ) . 'core/helper_functions.php';

add_action( 'init', 'wpo_stop_heartbeat', 1 );
function wpo_stop_heartbeat() {
	wp_deregister_script( 'heartbeat' );
}

/**
 * Manage WooCommerce styles and scripts.
 */
add_action( 'wp_enqueue_scripts', 'wpo_woocommerce_script_cleaner', 99 );
function wpo_woocommerce_script_cleaner() {
	if ( ! class_exists( 'woocommerce' ) ) {
		return;
	}

	// Remove the generator tag
	remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );

	// Unless we're in the store, remove all the cruft!
	if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
		wp_dequeue_style( 'woocommerce_frontend_styles' );
		wp_dequeue_style( 'woocommerce-general' );
		wp_dequeue_style( 'woocommerce-layout' );
		wp_dequeue_style( 'woocommerce-smallscreen' );
		wp_dequeue_style( 'woocommerce_fancybox_styles' );
		wp_dequeue_style( 'woocommerce_chosen_styles' );
		wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
		wp_dequeue_script( 'selectWoo' );
		wp_deregister_script( 'selectWoo' );
		wp_dequeue_script( 'wc-add-payment-method' );
		wp_dequeue_script( 'wc-lost-password' );
		wp_dequeue_script( 'wc_price_slider' );
		wp_dequeue_script( 'wc-single-product' );
		wp_dequeue_script( 'wc-add-to-cart' );
		wp_dequeue_script( 'wc-geolocation' );
		wp_dequeue_script( 'wc-cart-fragments' );
		wp_dequeue_script( 'wc-credit-card-form' );
		wp_dequeue_script( 'wc-checkout' );
		wp_dequeue_script( 'wc-add-to-cart-variation' );
		wp_dequeue_script( 'wc-single-product' );
		wp_dequeue_script( 'wc-cart' );
		wp_dequeue_script( 'wc-chosen' );
		wp_dequeue_script( 'woocommerce' );
		wp_dequeue_script( 'prettyPhoto' );
		wp_dequeue_script( 'prettyPhoto-init' );
		wp_dequeue_script( 'jquery-blockui' );
		wp_dequeue_script( 'jquery-placeholder' );
		wp_dequeue_script( 'jquery-payment' );
		wp_dequeue_script( 'fancybox' );
		wp_dequeue_script( 'jqueryui' );
	}
}

register_activation_hook( __FILE__, 'wpo_on_activate' );
function wpo_on_activate() {
	wpo_save_setting();
}

register_deactivation_hook( __FILE__, 'wpo_on_deactivate' );
function wpo_on_deactivate() {
	wpo_unset_setting();
}