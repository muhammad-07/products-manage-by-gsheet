<?php


add_action('admin_menu', 'gsheet_products_menu');

function gsheet_products_menu() {
    add_menu_page(
        'GSheet Products Settings',
        'GSheet Products',
        'manage_options',
        'gsheet-products-settings',
        'gsheet_products_settings_page',
        'dashicons-media-spreadsheet',
        7
    );
}
add_action('admin_menu', 'gsheet_products_menu');

// Step 2: Add Input Fields
function gsheet_products_settings_page() {
    ?>
    <div class="wrap">
        <h2>GSheet Products Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('gsheet_products_options'); ?>
            <?php do_settings_sections('gsheet-products-settings'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function gsheet_products_settings_init() {
    add_settings_section(
        'gsheet_products_section',
        'Settings Section',
        'gsheet_products_section_callback',
        'gsheet-products-settings'
    );
    add_settings_field(
        'gsheet_api_key',
        'Google Sheet API Key',
        'api_key_callback',
        'gsheet-products-settings',
        'gsheet_products_section'
    );
    add_settings_field(
        'gsheet_id',
        'Sheet ID',
        'field_sheet_id',
        'gsheet-products-settings',
        'gsheet_products_section'
    );
    add_settings_field(
        'gsheet_name',
        'Sheet Name',
        'field_sheet_name',
        'gsheet-products-settings',
        'gsheet_products_section',
        array(
            'label_for' => 'my_plugin_option',
            'class' => 'my-plugin-option-class',
            'description' => 'This is a description to help you with this option.'
        )
    );
    
    register_setting(
        'gsheet_products_options',
        'gsheet_api_key'
    );
    register_setting(
        'gsheet_products_options',
        'gsheet_id'
    );
    register_setting(
        'gsheet_products_options',
        'gsheet_name'
    );
    
}
add_action('admin_init', 'gsheet_products_settings_init');

function gsheet_products_section_callback() {
    echo 'Enter your google sheet authentication details below:';
}

function field_sheet_name() {
    $option = get_option('gsheet_name');
    echo "<input type='text' class='input-width' name='gsheet_name' value='$option' placeholder='Sheet1' />";
}
function field_sheet_id() {
    $option = get_option('gsheet_id');
    echo "<input type='text' class='input-width' name='gsheet_id' value='$option' />";
}
function api_key_callback() {
    $option = get_option('gsheet_api_key');
    echo "<input type='text' class='input-width' name='gsheet_api_key' value='$option' /><span title='Goto https://support.google.com/googleapi/answer/6158862 to get your google sheet API Key' class='dashicons dashicons-info'></span>";
}
// Step 3: Save Values
// WordPress will handle saving the values automatically when you submit the form.

// Step 4: Retrieve Values
$gsheet_products_option = get_option('gsheet_products_option');