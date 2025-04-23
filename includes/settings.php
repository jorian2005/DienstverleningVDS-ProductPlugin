<?php
add_action('admin_init', 'vds_register_settings');

function vds_register_settings() {
    register_setting('vds_settings_group', 'vds_setting_amount');
    register_setting('vds_settings_group', 'vds_setting_category');	

    add_settings_section(
        'vds_settings_section',
        'Algemene Instellingen',
        'vds_settings_section_callback',
        'vds-producten-settings'
    );

    add_settings_field(
        'vds_setting_amount',
        'Aantal weergeven producten',
        'vds_setting_amount_callback',
        'vds-producten-settings',
        'vds_settings_section'
    );
}

function vds_settings_section_callback() {
    echo '<p>Pas hier de instellingen aan voor VDS Producten.</p>
    <p>Shortcode = [vds_producten]</p>';
    
}

function vds_setting_amount_callback() {
    $value = get_option('vds_setting_amount', '');
    echo '<input type="text" name="vds_setting_amount" value="' . esc_attr($value) . '" />';
}