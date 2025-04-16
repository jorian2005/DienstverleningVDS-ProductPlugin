<?php

function vds_enqueue_scripts() {
    wp_enqueue_script(
        'vds-product-script',
        plugin_dir_url(__FILE__) . 'assets/js/vds-product.js',
        array('jquery'),
        null,
        true 
    );
}

function vds_enqueue_styles() {
    wp_enqueue_style(
        'vds-product-style',
        plugin_dir_url(__FILE__) . 'assets/css/single-product.css',
        array(), 
        null
    );
}