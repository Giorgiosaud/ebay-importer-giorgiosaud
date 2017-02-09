<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link        http://giorgiosaud.com/site/ 
 * @since      1.0.0
 *
 * @package    Ebay_Importer_Giorgiosaud
 * @subpackage Ebay_Importer_Giorgiosaud/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ebay_Importer_Giorgiosaud
 * @subpackage Ebay_Importer_Giorgiosaud/includes
 * @author     Giorgiosaud <jorgelsaud@gmail.com>
 */
class Ebay_Importer_Giorgiosaud_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ebay-importer-giorgiosaud',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
