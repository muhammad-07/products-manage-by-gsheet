<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://adbrains.in
 * @since      1.0.0
 *
 * @package    Products_Manage_By_Gsheet
 * @subpackage Products_Manage_By_Gsheet/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Products_Manage_By_Gsheet
 * @subpackage Products_Manage_By_Gsheet/includes
 * @author     Adbrains <info@artcloud.fi>
 */
class Products_Manage_By_Gsheet_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'products-manage-by-gsheet',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
