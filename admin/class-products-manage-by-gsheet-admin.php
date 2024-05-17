<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://adbrains.in
 * @since      1.0.0
 *
 * @package    Products_Manage_By_Gsheet
 * @subpackage Products_Manage_By_Gsheet/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Products_Manage_By_Gsheet
 * @subpackage Products_Manage_By_Gsheet/admin
 * @author     Adbrains <info@artcloud.fi>
 */
class Products_Manage_By_Gsheet_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
	// public function my_plugin_menu() {
	// 	add_menu_page(
	// 		'My Plugin Settings',
	// 		'My Plugin',
	// 		'manage_options',
	// 		'my-plugin-settings',
	// 		array($this, 'my_plugin_settings_page')
	// 	);
	// }
	// public function my_plugin_settings_page() {
    //     ? >
    //     <div class="wrap">
    //         <h2>My Plugin Settings</h2>
    //         <form method="post" action="options.php">
    //             <?php settings_fields('my_plugin_options'); ? >
    //             <?php do_settings_sections('my-plugin-settings'); ? >
    //             <?php submit_button(); ? >
    //         </form>
    //     </div>
    //     <?php
    // }

    // public function my_plugin_settings_init() {
    //     add_settings_section(
    //         'my_plugin_section',
    //         'Settings Section',
    //         array($this, 'my_plugin_section_callback'),
    //         'my-plugin-settings'
    //     );

    //     add_settings_field(
    //         'my_plugin_option',
    //         'My Plugin Option',
    //         array($this, 'my_plugin_option_callback'),
    //         'my-plugin-settings',
    //         'my_plugin_section'
    //     );

    //     register_setting(
    //         'my_plugin_options',
    //         'my_plugin_option'
    //     );
    // }

    // public function my_plugin_section_callback() {
    //     echo 'Enter your plugin settings below:';
    // }

    // public function my_plugin_option_callback() {
    //     $option = get_option('my_plugin_option');
    //     echo "<input type='text' name='my_plugin_option' value='$option' />";
    // }
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Products_Manage_By_Gsheet_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Products_Manage_By_Gsheet_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/products-manage-by-gsheet-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Products_Manage_By_Gsheet_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Products_Manage_By_Gsheet_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/products-manage-by-gsheet-admin.js', array( 'jquery' ), $this->version, false );

	}

}
