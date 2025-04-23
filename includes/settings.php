<?php
add_action('admin_init', 'vds_register_settings');

function vds_register_settings() {
    register_setting('vds_settings_group', 'vds_setting_amount');
    register_setting('vds_settings_group', 'vds_setting_heading_title');

    add_settings_section(
        'vds_settings_section',
        'Algemene Instellingen',
        'vds_settings_section_callback',
        'vds-producten-settings'
    );

    add_settings_section(
        'vds_settings_section_shortcode',
        'Shortcode Instellingen',
        'vds_settings_section_shortcode_callback',
        'vds-producten-settings'
    );

    add_settings_field(
        'vds_setting_amount',
        'Aantal weergeven producten',
        'vds_setting_amount_callback',
        'vds-producten-settings',
        'vds_settings_section_shortcode'
    );

    add_settings_field(
        'vds_setting_heading_title',
        'Koptekst',
        'vds_setting_heading_title_callback',
        'vds-producten-settings',
        'vds_settings_section_shortcode'
    );
}

function vds_settings_section_callback() {
    echo '<p>Op dit moment zijn er nog geen algemene instellingen</p><br><br><br>';
} 

// TODO: Voeg functie toe: Weergave prijs alternatief (prijs op aanvraag etc.)

function vds_settings_section_shortcode_callback() {
    echo '<p>Pas hier de instellingen aan voor de shortcode.</p>';
    echo '<p>Let op: de instellingen worden pas zichtbaar na het opslaan van de instellingen.</p>';
}

function vds_setting_amount_callback() {
    $value = get_option('vds_setting_amount', '');
    echo '<input type="text" name="vds_setting_amount" value="' . esc_attr($value) . '" />';
}

function vds_setting_heading_title_callback() {
    $value = get_option('vds_setting_heading_title', '');
    echo '<input type="text" name="vds_setting_heading_title" value="' . esc_attr($value) . '" /><br>';
    echo '<small>Deze tekst wordt boven de producten weergegeven.</small>';	
}