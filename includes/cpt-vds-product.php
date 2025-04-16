<?php
function vds_register_product_cpt() {
    $labels = [
        'name' => 'VDS Producten',
        'singular_name' => 'VDS Product',
        'add_new' => 'Nieuw product',
        'add_new_item' => 'Nieuw VDS Product toevoegen',
        'edit_item' => 'Product bewerken',
        'new_item' => 'Nieuw product',
        'view_item' => 'Bekijk product',
        'search_items' => 'Zoek producten',
        'not_found' => 'Geen producten gevonden',
        'menu_name' => 'VDS Producten',
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'vds-product'],
        'supports' => ['title', 'editor', 'thumbnail'],
        'menu_position' => 5,
        'menu_icon' => 'dashicons-cart',
    ];

    register_post_type('vds_product', $args);
}
