<?php

function gsheet_add_section($sections) {
    $sections['gsheet_products'] = __('GSheet Products', 'text-domain');
    return $sections;
}
add_filter('woocommerce_get_sections_advanced', 'gsheet_add_section');

function gsheet_all_settings($settings, $current_section) {
    if ($current_section == 'gsheet_products') {
        $gsheet_settings = array();

        // Add Title to the Settings
        $gsheet_settings[] = array(
            'name' => __('GSheet Products Settings', 'text-domain'),
            'type' => 'title',
            'desc' => __('The following options are used to configure GSheet Products', 'text-domain'),
            'id'   => 'gsheet_products_title'
        );

        // Add a Text Field
        $gsheet_settings[] = array(
            'name' => __('Google Sheet ID', 'text-domain'),
            'type' => 'text',
            'desc' => __('Enter your Google Sheet ID.', 'text-domain'),
            'id'   => 'gsheet_products_google_sheet_id'
        );

        // Add a Checkbox Field
        $gsheet_settings[] = array(
            'name' => __('Enable Sync', 'text-domain'),
            'type' => 'checkbox',
            'desc' => __('Enable Google Sheets sync.', 'text-domain'),
            'id'   => 'gsheet_products_enable_sync'
        );

        // Add Section End
        $gsheet_settings[] = array(
            'type' => 'sectionend',
            'id'   => 'gsheet_products_end'
        );

        return $gsheet_settings;
    } else {
        return $settings;
    }
}
add_filter('woocommerce_get_settings_advanced', 'gsheet_all_settings', 10, 2);
