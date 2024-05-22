<?php
function gsheet_custom_admin_styles() {
    echo '

    <style>
        .tooltip {
    position: relative;
    display: inline-block;
    padding-left: 20px;
}

/* Tooltip text */
.tooltip .tooltiptext {
    /* visibility: hidden;
    width: 120px;
    background-color: #555;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    margin-left: -60px;
    opacity: 0;
    transition: opacity 0.3s; */

    display: flex;
    flex-direction: column;
}
.tooltip .tooltiptext img {
    max-width: 750px;
}

    
        .gsheet-settings-field {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .gsheet-settings-field label {
            width: 150px;
            font-weight: bold;
        }
        
        .gsheet-settings-field input[type="text"] {
            width: 300px;
            padding: 5px;
        }

        .gsheet-settings-field .tooltip {
            margin-left: 10px;
            margin-top: 30px;
            margin-bottom: 30px;
        }
        .gsheet-settings-field .tooltip .tooltiptext a {
            display: contents;
        }
        
    </style>';
}
add_action('admin_head', 'gsheet_custom_admin_styles');
// Add a new settings tab
add_filter('woocommerce_settings_tabs_array', 'gsheet_add_settings_tab', 50);

function gsheet_add_settings_tab($tabs) {
    $tabs['gsheet_products'] = __('GSheet Products', 'text-domain');
    return $tabs;
}

// Show settings content
add_action('woocommerce_settings_tabs_gsheet_products', 'gsheet_settings_tab_content');

function gsheet_settings_tab_content() {
    $settings = gsheet_get_settings();
    foreach ($settings as $setting) {
        if (isset($setting['custom_callback'])) {
            call_user_func($setting['custom_callback']);
        } else {
            woocommerce_admin_fields(array($setting));
        }
    }
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
            'name'     => __('Google Sheet API Key', 'text-domain'),
            'type'     => 'text',
            'id'       => 'gsheet_api_key',
            'desc'     => '',
            'custom_callback' => 'gsheet_api_key_callback'
        ),
        'gsheet_id' => array(
            'name'     => __('Sheet ID', 'text-domain'),
            'type'     => 'text',
            'id'       => 'gsheet_id',
            'desc'     => '',
            'custom_callback' => 'gsheet_id_callback'
        ),
        'gsheet_name' => array(
            'name'     => __('Sheet Name', 'text-domain'),
            'type'     => 'text',
            'id'       => 'gsheet_name',
            'desc'     => '',
            'custom_callback' => 'gsheet_name_callback'
        ),
        'section_end' => array(
            'type'     => 'sectionend',
            'id'       => 'gsheet_products_end'
        )
    );
    return apply_filters('gsheet_get_settings', $settings);
}

// Save settings
add_action('woocommerce_update_options_gsheet_products', 'gsheet_update_settings');

function gsheet_update_settings() {
    woocommerce_update_options(gsheet_get_settings());
}

// Custom callback functions


function gsheet_api_key_callback() {
    $value = get_option('gsheet_api_key');
    echo '<div class="gsheet-settings-field">';
    echo '<label for="gsheet_api_key">' . __('Google Sheet API Key', 'text-domain') . '</label>';
    echo '<input type="text" id="gsheet_api_key" name="gsheet_api_key" value="' . esc_attr($value) . '" />';
    echo '<span class="tooltip">
        <span class="tooltiptext"><img src="' . plugin_dir_url(__FILE__) . 'public/screenshots/api_key.PNG" />Visit <a target="_blank" rel="noopener noreferrer nofollow" href="https://support.google.com/googleapi/answer/6158862?hl=en">https://support.google.com/googleapi/answer/6158862</a> to get help on how to get your google sheet API Key</span>
    </span>';
    echo '</div><hr/>';
}

function gsheet_id_callback() {
    $value = get_option('gsheet_id');
    echo '<div class="gsheet-settings-field">';
    echo '<label for="gsheet_id">' . __('Sheet ID', 'text-domain') . '</label>';
    echo '<input type="text" id="gsheet_id" name="gsheet_id" value="' . esc_attr($value) . '" />';
    echo '<span class="tooltip">
        <span class="tooltiptext"><img src="' . plugin_dir_url(__FILE__) . 'public/screenshots/sheet_id.PNG" />You can find the sheet ID in the URL</span>
    </span>';
    echo '</div><hr/>';
}

function gsheet_name_callback() {
    $value = get_option('gsheet_name');
    echo '<div class="gsheet-settings-field">';
    echo '<label for="gsheet_name">' . __('Sheet Name', 'text-domain') . '</label>';
    echo '<input type="text" id="gsheet_name" name="gsheet_name" value="' . esc_attr($value) . '" />';
    echo '<span class="tooltip">
        <span class="tooltiptext"><img src="' . plugin_dir_url(__FILE__) . 'public/screenshots/sheet_name.PNG" />Name of the sheet you want to synchronize.</span>
    </span>';
    echo '</div>';
}
