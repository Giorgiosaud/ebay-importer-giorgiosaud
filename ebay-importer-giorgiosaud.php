<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link               http://giorgiosaud.com/site/ 
 * @since             1.0.0
 * @package           Ebay_Importer_Giorgiosaud
 *
 * @wordpress-plugin
 * Plugin Name:       Ebay Importer Giorgiosaud
 * Plugin URI:         http://giorgiosaud.com/site/2017/02/09/ebay-importer-giorgiosaud/ ‎
 * Description:       This plugin is to import products from one ebay store to your woocomerce products.
 * Version:           1.0.0
 * Author:            Giorgiosaud
 * Author URI:         http://giorgiosaud.com/site/ 
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ebay-importer-giorgiosaud
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ebay-importer-giorgiosaud-activator.php
 */
function activate_ebay_importer_giorgiosaud() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ebay-importer-giorgiosaud-activator.php';
	Ebay_Importer_Giorgiosaud_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ebay-importer-giorgiosaud-deactivator.php
 */
function deactivate_ebay_importer_giorgiosaud() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ebay-importer-giorgiosaud-deactivator.php';
	Ebay_Importer_Giorgiosaud_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ebay_importer_giorgiosaud' );
register_deactivation_hook( __FILE__, 'deactivate_ebay_importer_giorgiosaud' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ebay-importer-giorgiosaud.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ebay_importer_giorgiosaud() {

	$plugin = new Ebay_Importer_Giorgiosaud();
	$plugin->run();

}
run_ebay_importer_giorgiosaud();
