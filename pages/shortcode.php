<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

echo '<meta name="viewport" content="width=device-width, initial-scale=1">' . "\n";

function dvds_show_last_three_products() {
    $args = array(
        'post_type'      => 'vds_product',
        'posts_per_page' => 4,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) {
        echo '<style>';
        echo file_get_contents(VDS_PLUGIN_PATH . 'assets/css/shortcode.css');
        echo '</style>';
        echo '<h2>Aanbevolen producten</h2>';
        echo '<ul class="vds-products">';
        while ($query->have_posts()) {
            $query->the_post();

            $price = get_post_meta(get_the_ID(), '_vds_prijs', true);
            $mainImage = get_post_meta(get_the_ID(), '_vds_product_mainimage', true);

            echo '<a href="' . get_permalink() . '">';
            echo '<div class="vds-product-image">';
            if ($mainImage) {
                echo '<img src="' . esc_url($mainImage) . '" alt="' . esc_attr(get_the_title()) . '">';
            } else {
                echo '<p class="italic">Geen afbeelding beschikbaar</p>';
            }
            echo '</div>';
            echo '<div class="product-title">' . get_the_title() . '</div>';
            if ($price) {
                echo '<div class="product-price">Prijs: €' . esc_html($price) . '</div>';
            }
            echo '</a>';
        }
        echo '</ul>';
    } else {
        echo '<p style="font-style: italic; color: #555; text-align: center; margin-top: 20px;">Op dit moment hebben wij niks te koop, probeer het later nog eens.</p>';
    }

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('last_three_products', 'dvds_show_last_three_products');