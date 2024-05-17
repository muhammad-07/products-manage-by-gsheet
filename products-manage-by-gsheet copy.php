<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://adbrains.in
 * @since             1.0.0
 * @package           Products_Manage_By_Gsheet
 *
 * @wordpress-plugin
 * Plugin Name:       Products Manage By GSheet
 * Plugin URI:        https://adbrains.in
 * Description:       Plugin to manage products via Google sheet
 * Version:           1.0.0
 * Author:            Adbrains
 * Author URI:        https://adbrains.in/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       products-manage-by-gsheet
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PRODUCTS_MANAGE_BY_GSHEET_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-products-manage-by-gsheet-activator.php
 */
function activate_products_manage_by_gsheet() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-products-manage-by-gsheet-activator.php';
	Products_Manage_By_Gsheet_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-products-manage-by-gsheet-deactivator.php
 */
function deactivate_products_manage_by_gsheet() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-products-manage-by-gsheet-deactivator.php';
	Products_Manage_By_Gsheet_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_products_manage_by_gsheet' );
register_deactivation_hook( __FILE__, 'deactivate_products_manage_by_gsheet' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-products-manage-by-gsheet.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_products_manage_by_gsheet() {

	$plugin = new Products_Manage_By_Gsheet();
	$plugin->run();

}
run_products_manage_by_gsheet();

defined('ABSPATH') || exit;

// Staging creds
// define('CONSUMER_KEY', 'ck_18350263f2b249b7265dc4edb6873c0d060a8a4e');
// define('CONSUMER_SECRET', 'cs_684b487ac81a4218050c99a5a649e66e271630f4');
define('SPREAD_SHEET_ID', '1yDYOB_7MkG6-koPVi3PSqaGpOnybw6HLT1d5EW5Scg8');
//define('SPREAD_SHEET_ID', '1iHNuFUI-sXQRQCZ7VlQWgROnh7CnreGKAkZ698cfGOc');
// define('NF_API_URL', 'https://staging-2.ornaterugs.com/wp-json/wc/v3');
define('NF_API_URL', 'http://any.test/index.php/wp-json/wc/v3');

define('SPREAD_SHEET_NAME', 'Sheet1');
define('SHEET_BATCH', '90');


add_action('admin_menu', 'my_plugin_menu');

function my_plugin_menu() {
    add_menu_page(
        'My Plugin Settings',
        'My Plugin',
        'manage_options',
        'my-plugin-settings',
        'my_plugin_settings_page'
    );
}
add_action('admin_menu', 'my_plugin_menu');

// Step 2: Add Input Fields
function my_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h2>My Plugin Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('my_plugin_options'); ?>
            <?php do_settings_sections('my-plugin-settings'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function my_plugin_settings_init() {
    add_settings_section(
        'my_plugin_section',
        'Settings Section',
        'my_plugin_section_callback',
        'my-plugin-settings'
    );

    add_settings_field(
        'sheet_id',
        'Sheet ID',
        'field_sheet_id',
        'my-plugin-settings',
        'my_plugin_section'
    );
    add_settings_field(
        'my_api_key',
        'My api_key',
        'api_key_callback',
        'my-plugin-settings',
        'my_plugin_section'
    );

    register_setting(
        'my_plugin_options',
        'sheet_id'
    );
    register_setting(
        'my_plugin_options',
        'my_api_key'
    );
}
add_action('admin_init', 'my_plugin_settings_init');

function my_plugin_section_callback() {
    echo 'Enter your plugin settings below:';
}

function field_sheet_id() {
    $option = get_option('sheet_id');
    echo "<input type='text' name='sheet_id' value='$option' />";
}
function api_key_callback() {
    $option = get_option('my_api_key');
    echo "<input type='text' name='my_api_key' value='$option' />";
}
// Step 3: Save Values
// WordPress will handle saving the values automatically when you submit the form.

// Step 4: Retrieve Values
$my_plugin_option = get_option('my_plugin_option');

// require_once(plugin_dir_path( __FILE__ ) . '/vendor/autoload.php');

function productdata_main()
{
    // ob_start();
    $url = 'https://sheets.googleapis.com/v4/spreadsheets/1iHNuFUI-sXQRQCZ7VlQWgROnh7CnreGKAkZ698cfGOc/values/Sheet1?key=AIzaSyBLFLNFW99432acHkaJxM_YGDtZPbgZqaY';
$response = wp_remote_get($url);
if (is_wp_error($response)) {
    // print_r($response->get_error_message());
    // Handle error
} else {
    // $data = wp_remote_retrieve_body($response);
    
    $data = json_decode(wp_remote_retrieve_body($response), true);
    echo count($data['values']);
    // print_r($data);
    // Process and display data
    // Example: 
    // foreach ($data['values'] as $row) {
    //     echo '<div>' . implode(' | ', $row) . '</div>';
    // }
}

    // $response = google_sheet_read();
    // $productsData = $response->getValues();
    // $total_products = count($productsData);
    // echo  $total_products;
    google_drive_sheet($data['values']);
}

// function google_sheet_read()
// {

//     $client = new Google_Client();
//     $client->setApplicationName('Google Sheets API');
//     $client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
//     $client->setAccessType('offline');
//     // credentials.json is the key file we downloaded while setting up our Google Sheets API
//     $path = plugin_dir_path(__FILE__) . 'data/credentials.json';
// 	//$path = plugin_dir_path(__FILE__) . 'data/sheetadb-50d973354676.json';
//     $client->setAuthConfig($path);
//     // configure the Sheets Service
//     $service = new Google_Service_Sheets($client);
//     $spreadsheetId = SPREAD_SHEET_ID;
//     $spreadsheet = $service->spreadsheets->get($spreadsheetId);
//     // get all the rows of a sheet
//     $range = SPREAD_SHEET_NAME; // here we use the name of the Sheet to get all the rows
//     //$range = 'Sheet1!A'.$strat_range.':BO'.$end_range;
//     $response = $service->spreadsheets_values->get($spreadsheetId, $range);
//     return ($response);
// }
//create product api call
// add_action('rest_api_init', function () {
//     register_rest_route('sheetsProducts/v3', 'addGoogleDriveProducts', array(
//         'methods' => WP_REST_SERVER::CREATABLE,
//         'callback' => 'productdata_main',
//         'permission_callback' => '__return_true',
//     ));
// });

// // delete product api call
// add_action('rest_api_init', function () {
//     register_rest_route('sheetsProducts/v3', 'deleteGoogleDriveProducts', array(
//         'methods' => WP_REST_SERVER::READABLE,
//         'callback' => 'productdata_delete',
//         'permission_callback' => '__return_true',
//     ));
// });

add_filter('woocommerce_rest_check_permissions', 'nf_google_drive_woocommerce_rest_check_permissions', 90, 4);

function nf_google_drive_woocommerce_rest_check_permissions($permission, $context, $object_id, $post_type)
{
    return true;
}
add_filter('woocommerce_rest_check_permissions', '__return_true');
add_action('insert_products_via_crons', 'productdata_main');

function google_drive_sheet($productsData)
{

    $productCreate = array();
    $productUpdate = array();
    $productSKUarray = array();

    foreach ($productsData as $index => $products) {

        $productDetailsArray = array();
        if ($index !== 0) {
            $custom_url_field = '_custom_product_images_url';
            if (empty($products[2])) {
                continue;
            }
            $productId = get_product_by_sku($products[2]);
            $api_url = NF_API_URL . '/products/batch';
            // check product stock 0
            if (($products[14] == 0)) {
                continue;       //skip when product stock is zero  
            }
            $productType = $products[1];
            $productSKU = $products[2];
            $productName = $products[3];
            $productPublished = $products[4];
            $productFeatured = $products[5];
            $productVisibility = $products[6];
            if ($productVisibility === 'hidden') {
                $productStatus = 'draft';
            } else {
                $productStatus = 'publish';
            }
            $productShortDescription = $products[7];
            $productDescription = $products[8];
            $productDateSaleStart = $products[9];
            $productDateSaleEnd = $products[10];
            $productTaxStatus = $products[11];
            $productTaxClass = $products[12];
            $productIsInStock = $products[13];
            $productStock = $products[14];
            $productBackordersAllowed = $products[15];
            $productSoldIndividually = $products[16];
            $productWeight = $products[17];
            $productLength = $products[18];
            $productWidth = $products[19];
            $productHeight = $products[20];
            $productAllowCustomerReviews = $products[21];
            $productPurchaseNote = $products[22];
            $productSalePrice = $products[23];
            $productRegularPrice = $products[24];
            $productCategories = $products[25];
            $productTags = $products[26];
            $productShippingClass = $products[27];
            $productImages = $products[28];
            $productDownloadLimit = $products[29];
            $productDownloadExpiryDays = $products[30];
            $productParent = $products[31];
            $productGroupedProducts = $products[32];
            $productUpsells = $products[33];
            $productCrossSells = $products[34];
            $productExternalURL = $products[35];
            $productButtonText = $products[36];
            $productPosition = $products[37];
            // attribute Length
            $attributes1_name    = str_replace(' ', '-', $products[38]);
            $attributes1_value   = explode(',', $products[39]);
            $attributes1_visible = $products[40];
            $attributes1_global  = $products[41];

            // attribute Width
            $attributes2_name    = str_replace(' ', '-', $products[42]);
            $attributes2_value   = explode(',', $products[43]);
            $attributes2_visible = $products[44];
            $attributes2_global  = $products[45];

            // attribute Rug Style
            $attributes3_name    = str_replace(' ', '-', $products[46]);
            $attributes3_value   = explode(',', $products[47]);
            $attributes3_visible = $products[48];
            $attributes3_global  = $products[49];

            // attribute texture
            $attributes4_name    = str_replace(' ', '-', $products[50]);
            $attributes4_value   = explode(',', $products[51]);
            $attributes4_visible = $products[52];
            $attributes4_global  = $products[53];

            // attribute rug type
            $attributes5_name    = str_replace(' ', '-', $products[54]);
            $attributes5_value   = explode(',', $products[55]);
            $attributes5_visible = $products[56];
            $attributes5_global  = $products[57];

            // attribute color
            $attributes6_name    = str_replace(' ', '-', $products[58]);
            $attributes6_value   = explode(',', $products[59]);
            $attributes6_visible = $products[60];
            $attributes6_global  = $products[61];

            // attribute location
            $attributes7_name    = str_replace(' ', '-', $products[62]);
            $attributes7_value   = explode(',', $products[63]);
            $attributes7_visible = $products[64];
            $attributes7_global  = $products[65];
            // Product Categories
            $categoriesIdArray  = addProductCategories($productCategories);
            $productDetailsArray = array(
                'name' => $productName,
                'slug' => $productName,
                'type' => $productType,
                'sku' => $productSKU,
                'catalog_visibility' => $productVisibility,
                'status' => $productStatus,
                'regular_price' => $productRegularPrice,
                'sale_price' => $productSalePrice,
                'description' => $productDescription,
                'short_description' => $productShortDescription,
                'categories' => $categoriesIdArray,
                'stock_quantity' => $productStock,
                'manage_stock' => $productIsInStock,
                'custom_attributes_array' =>  array(
                    $productSKU => array(
                        array(
                            $attributes1_name,
                            $attributes1_value,
                            $attributes1_visible
                        ),
                        array(
                            $attributes2_name,
                            $attributes2_value,
                            $attributes2_visible
                        ),
                        array(
                            $attributes3_name,
                            $attributes3_value,
                            $attributes3_visible
                        ),
                        array(
                            $attributes4_name,
                            $attributes4_value,
                            $attributes4_visible
                        ),
                        array(
                            $attributes5_name,
                            $attributes5_value,
                            $attributes5_visible
                        ),
                        array(
                            $attributes6_name,
                            $attributes6_value,
                            $attributes6_visible
                        ),

                        array(
                            $attributes7_name,
                            $attributes7_value,
                            $attributes7_visible
                        )
                    )
                )
            );

            $productDetailsArray['meta_data'] = array(
                array(
                    'key'   => $custom_url_field,
                    'value' => strtolower($productImages)
                )
            );
            if (is_object($productId) && $productId->get_id() > 0) {
                $productDetailsArray['id'] = $productId->get_id();
                $productUpdate[$productSKU] = $productDetailsArray;
            } else {
                $productCreate[$productSKU] = $productDetailsArray;
            }
        }
    }

    $productCreate_chunk = array_chunk($productCreate, SHEET_BATCH);
    $productUpdate_chunk = array_chunk($productUpdate, SHEET_BATCH);

    if (is_array($productCreate_chunk) && count($productCreate_chunk) > 0) {
        foreach ($productCreate_chunk as $key => $productInfo) {
            $product_data['create'] = $productInfo;
            $productData = $product_data;
            $product_attributes = array_column($productData['create'], 'custom_attributes_array');
            $api_url = NF_API_URL . '/products/batch';
            $productData = json_encode($productData, false);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $api_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $productData,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $responseData = json_decode($response);
            foreach ($product_attributes as $product_attr) {
                foreach ($product_attr as $p_key => $p_value) {
                    $product_object = get_product_by_sku($p_key);
                    $product_id = $product_object->id;
                    if (!empty($product_id)) {
                        $att_array = array();
                        foreach ($p_value as $pk_attr => $pv_attr) {

                            // product attributes Length
                            $attributes_name = $pv_attr[0];
                            $attributes_value = $pv_attr[1];
                            $attributes_visible = $pv_attr[2];

                            if (!empty($attributes_name)) {
                                $pa_label = 'pa_' . strtolower($attributes_name);
                                wp_set_object_terms($product_id, $attributes_value, $pa_label, true);

                                $pa_attr_array = array(
                                    'name'  => $pa_label,
                                    'value' => $attributes_value,
                                    'is_visible' => $attributes_visible,
                                    'is_taxonomy' => '1'
                                );
                                $att_array[$pa_label] = $pa_attr_array;
                            }
                            update_post_meta($product_id, '_product_attributes', $att_array);
                        }
                    }
                }
            }
        }
    }
    // update product
    if (is_array($productUpdate_chunk) && count($productUpdate_chunk) > 0) {
        foreach ($productUpdate_chunk as $key => $productInfo) {
            $product_data['update'] = $productInfo;
            // addUpdateBulkProduct($product_data,'update');
            // get product attributes
            $productData = $product_data;
            $product_attributes = array_column($productData['update'], 'custom_attributes_array');
            $api_url = NF_API_URL . '/products/batch';
            $productData = json_encode($productData, false);

            // add product with api
            // ob_start();
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $api_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $productData,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $responseData = json_decode($response);
            foreach ($product_attributes as $product_attr) {
                foreach ($product_attr as $p_key => $p_value) {
                    $product_object = get_product_by_sku($p_key);
                    $product_id = $product_object->id;
                    if (!empty($product_id)) {
                        $att_array = array();
                        // Update manage_stock, stock_quantity, stock_status
                        // $manage_stock = false; // Set to true if you want to manage stock
                        // $stock_quantity = 0; // Set the stock quantity
                        // $stock_status = 'outofstock'; // Set the stock status (instock, outofstock, etc.)

                        // update_post_meta($product_id, '_manage_stock', $manage_stock);
                        // update_post_meta($product_id, '_stock', $stock_quantity);
                        // update_post_meta($product_id, '_stock_status', $stock_status);
                        foreach ($p_value as $pk_attr => $pv_attr) {

                            $attributes_name = $pv_attr[0];
                            $attributes_value = $pv_attr[1];
                            $attributes_visible = $pv_attr[2];

                            if (!empty($attributes_name)) {
                                $pa_label = 'pa_' . strtolower($attributes_name);
                                wp_set_object_terms($product_id, $attributes_value, $pa_label, true);

                                $pa_attr_array = array(
                                    'name'  => $pa_label,
                                    'value' => $attributes_value,
                                    'is_visible' => $attributes_visible,
                                    'is_taxonomy' => '1'
                                );
                                $att_array[$pa_label] = $pa_attr_array;
                            }
                            update_post_meta($product_id, '_product_attributes', $att_array);
                        }
                    }
                }
            }
            // echo '<br>Update function<br>';
            // print_r($responseData);
        }
    }

//delete products from site if not exist in google sheet
$googleSheetSKUs = array();
foreach ($productsData as $index => $products) {
    if ($index !== 0) {
        $googleSheetSKUs[] = $products[2];
    }
}

$args = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'fields' => 'ids',
);

$liveSiteSKUs = array();
$productsQuery = new WP_Query($args);

if ($productsQuery->have_posts()) {
    while ($productsQuery->have_posts()) {
        $productsQuery->the_post();
        $product = wc_get_product(get_the_ID());
        $liveSiteSKUs[] = $product->get_sku();
    }
    wp_reset_postdata();
}

$productsToDelete = array_diff($liveSiteSKUs, $googleSheetSKUs);

foreach ($productsToDelete as $skuToDelete) {
    $productToDelete = wc_get_product_id_by_sku($skuToDelete);

    if ($productToDelete) {
        wp_delete_post($productToDelete, true);
        echo 'Product with SKU ' . $skuToDelete . ' has been deleted.';
    } else {
        echo 'Product with SKU ' . $skuToDelete . ' not found.';
    }
}

}

function get_product_by_sku($sku)
{

    global $wpdb;

    $product_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku));

    if ($product_id) {
        return new WC_Product($product_id);
    } else {

        return null;
    }
}

// add categories function
function addProductCategories($categories)
{
    $categoriesArray = explode(",", $categories);
    $categoriesResult = array();

    for ($i = 0; $i < count($categoriesArray); $i++) {
        $catArray = explode('>', $categoriesArray[$i]);
        for ($k = 0; $k < count($catArray); $k++) {
            $finalcategories = array();
            $catName = trim($catArray[$k]);
            $finalcategories['name'] =  $catName;
            if ($k > 0) {
                $catName = trim($catArray[$k - 1]);
                $finalcategories['parent'] = getCategoryId($catName);
            }

            $categotyObject = json_encode($finalcategories, false);

            // add category
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => NF_API_URL . '/products/categories',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $categotyObject,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $responseData = json_decode($response, true);
            if (!empty($responseData) && is_array($responseData)) {
                // check category already exists           
                if (array_key_exists('code', $responseData)) {
                    if ($responseData['code'] == "term_exists") {
                        $categoriesResult[]['id'] = array_key_exists('data', $responseData) ? $responseData['data']['resource_id'] : null;
                    }
                } else {
                    if (array_key_exists('id', $responseData)) {
                        $categoriesResult[]['id'] = $responseData['id'];
                    }
                }
            }
        }
    }
    return $categoriesResult;
}

function getCategoryId($category)
{
    $categoriesResult = array();
    $categoies['name'] = $category;
    $categotyObject = json_encode($categoies, false);
    // add category
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => NF_API_URL . '/products/categories',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $categotyObject,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    $responseData = json_decode($response, true);
    if (!empty($responseData) && is_array($responseData)) {
        // check category already exists           
        if (array_key_exists('code', $responseData)) {
            if ($responseData['code'] == "term_exists") {
                $categoriesResult = array_key_exists('data', $responseData) ? $responseData['data']['resource_id'] : null;
            }
        } else {
            if (array_key_exists('id', $responseData)) {
                $categoriesResult = $responseData['id'];
            }
        }
    }
    return $categoriesResult;
}
