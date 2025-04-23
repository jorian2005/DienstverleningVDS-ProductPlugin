<?php
/*
Plugin Name: VDS Producten
Description: Plugin voor Dienstverlening van der Sluis om producten te beheren en weer te geven.
Version: 1.0
Author: Jorian Beukens
Author URI: https://jorianbeukens.nl
*/

defined('ABSPATH') or die('No direct access');

define('VDS_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Includes
require_once VDS_PLUGIN_PATH . 'includes/cpt-vds-product.php';
require_once VDS_PLUGIN_PATH . 'includes/meta-boxes.php';
require_once VDS_PLUGIN_PATH . 'includes/templates.php';
require_once VDS_PLUGIN_PATH . 'includes/enqueue.php';
require_once VDS_PLUGIN_PATH . 'includes/settings.php';

require_once VDS_PLUGIN_PATH . 'pages/shortcode.php';

// Hooks
add_action('init', 'vds_register_product_cpt');
add_action('add_meta_boxes', 'vds_register_meta_boxes');
add_action('save_post', 'vds_save_meta_boxes');
add_filter('template_include', 'vds_template_override');
add_action('wp_enqueue_scripts', 'vds_enqueue_scripts');
add_action('wp_enqueue_scripts', 'vds_enqueue_styles');


// Hook voor het toevoegen van een instellingenpagina
add_action('admin_menu', 'vds_add_settings_page');

/**
 * Voeg een instellingenpagina toe aan het admin menu.
 */
function vds_add_settings_page() {
    add_menu_page(
        'VDS Producten Instellingen', // Paginatitel
        'VDS Instellingen',          // Menu-item titel
        'manage_options',            // Capaciteit (rechten)
        'vds-producten-settings',    // Slug
        'vds_render_settings_page',  // Callback voor de inhoud
        'dashicons-admin-generic',   // Icon (optioneel)
        80                           // Positie in het menu (optioneel)
    );
}

/**
 * Render de instellingenpagina.
 */
function vds_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>VDS Producten Instellingen</h1>
        <form method="post" action="options.php">
            <?php
            // WordPress instellingen API gebruiken
            settings_fields('vds_settings_group');
            do_settings_sections('vds-producten-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}