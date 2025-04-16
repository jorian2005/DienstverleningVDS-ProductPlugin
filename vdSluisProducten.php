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

// Hooks
add_action('init', 'vds_register_product_cpt');
add_action('add_meta_boxes', 'vds_register_meta_boxes');
add_action('save_post', 'vds_save_meta_boxes');
add_filter('template_include', 'vds_template_override');
add_action('wp_enqueue_scripts', 'vds_enqueue_scripts');
add_action('wp_enqueue_scripts', 'vds_enqueue_styles');
