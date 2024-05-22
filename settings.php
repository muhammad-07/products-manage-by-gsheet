<?php
// Add a new settings tab
add_filter('woocommerce_settings_tabs_array', 'gsheet_add_settings_tab', 50);

function gsheet_add_settings_tab($tabs) {
    $tabs['gsheet_products'] = __('GSheet Products', 'text-domain');
    return $tabs;
}

// Show settings content
add_action('woocommerce_settings_tabs_gsheet_products', 'gsheet_settings_tab_content');

function gsheet_settings_tab_content() {
    woocommerce_admin_fields(gsheet_get_settings());
}

// Define settings
function gsheet_get_settings() {
    $settings = array(
        'section_title' => array(
            'name'     => __('GSheet Products Settings', 'text-domain'),
            'type'     => 'title',
            'desc'     => __('Configure the GSheet Products settings below.', 'text-domain'),
            'id'       => 'gsheet_products_title'
        ),
        'gsheet_api_key' => array(
            'name' => __('Google Sheet API Key', 'text-domain'),
            'type' => 'text',
            'desc' => __('Enter your Google Sheet API Key.', 'text-domain'),
            'id'   => 'gsheet_api_key'
        ),
        'gsheet_id' => array(
            'name' => __('Sheet ID', 'text-domain'),
            'type' => 'text',
            'desc' => __('Enter your Google Sheet ID.', 'text-domain'),
            'id'   => 'gsheet_id'
        ),
        'gsheet_name' => array(
            'name' => __('Sheet Name', 'text-domain'),
            'type' => 'text',
            'desc' => __('Enter your Google Sheet Name.', 'text-domain'),
            'id'   => 'gsheet_name'
        ),
        'section_end' => array(
            'type' => 'sectionend',
            'id'   => 'gsheet_products_end'
        )
    );
    return apply_filters('gsheet_get_settings', $settings);
}

// Save settings
add_action('woocommerce_update_options_gsheet_products', 'gsheet_update_settings');

function gsheet_update_settings() {
    woocommerce_update_options(gsheet_get_settings());
}
