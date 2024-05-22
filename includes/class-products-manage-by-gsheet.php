<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://adbrains.in
 * @since      1.0.0
 *
 * @package    Products_Manage_By_Gsheet
 * @subpackage Products_Manage_By_Gsheet/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Products_Manage_By_Gsheet
 * @subpackage Products_Manage_By_Gsheet/includes
 * @author     Adbrains <info@artcloud.fi>
 */
class Products_Manage_By_Gsheet {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Products_Manage_By_Gsheet_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PRODUCTS_MANAGE_BY_GSHEET_VERSION' ) ) {
			$this->version = PRODUCTS_MANAGE_BY_GSHEET_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'products-manage-by-gsheet';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_rest_api_hooks();

		
	}
	
	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Products_Manage_By_Gsheet_Loader. Orchestrates the hooks of the plugin.
	 * - Products_Manage_By_Gsheet_i18n. Defines internationalization functionality.
	 * - Products_Manage_By_Gsheet_Admin. Defines all hooks for the admin area.
	 * - Products_Manage_By_Gsheet_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-products-manage-by-gsheet-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-products-manage-by-gsheet-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-products-manage-by-gsheet-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-products-manage-by-gsheet-public.php';


		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'vendor/autoload.php';

		$this->loader = new Products_Manage_By_Gsheet_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Products_Manage_By_Gsheet_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Products_Manage_By_Gsheet_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	private function define_rest_api_hooks() {

		add_action('rest_api_init', function () {
			register_rest_route('sheetsProducts/v4', 'addGoogleDriveProducts', array(
				'methods' => WP_REST_Server::READABLE,
				'callback' => 'productdata_main',
				'permission_callback' => '__return_true',
			));
		});
		add_action('rest_api_init', function () {
			register_rest_route('sheetsProducts/v4', 'deleteGoogleDriveProducts', array(
				'methods' => WP_REST_Server::READABLE,
				'callback' => 'productdata_delete',
				'permission_callback' => '__return_true',
			));
		});
		//create product api call
add_action('rest_api_init', function () {
    register_rest_route('sheetsProducts/v3', 'addGoogleDriveProducts', array(
        'methods' => WP_REST_SERVER::CREATABLE,
        'callback' => 'productdata_main',
        'permission_callback' => '__return_true',
    ));
});

// delete product api call
add_action('rest_api_init', function () {
    register_rest_route('sheetsProducts/v3', 'deleteGoogleDriveProducts', array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'productdata_delete',
        'permission_callback' => '__return_true',
    ));
});
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Products_Manage_By_Gsheet_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		// $this->loader->add_action( 'admin_menu', $plugin_admin, 'my_plugin_menu' );

		// add_action('admin_menu', 'my_plugin_menu');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Products_Manage_By_Gsheet_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Products_Manage_By_Gsheet_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
