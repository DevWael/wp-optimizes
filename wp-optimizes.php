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

register_activation_hook( __FILE__, 'wpo_on_activate' );
function wpo_on_activate() {
	wpo_save_setting();
}

register_deactivation_hook( __FILE__, 'wpo_on_deactivate' );
function wpo_on_deactivate() {
	wpo_unset_setting();
}