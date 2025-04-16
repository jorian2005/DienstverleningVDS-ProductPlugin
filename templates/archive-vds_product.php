<?php
echo '<meta name="viewport" content="width=device-width, initial-scale=1">' . "\n";
echo '<style>';
echo file_get_contents(plugin_dir_path(__FILE__) . 'assets/css/archive-product.css');
echo '</style>';

get_header();
?>

<div class="vds-producten-archief">
    <h1>Onze Producten</h1>
    <div class="vds-grid">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="vds-product">
                <a href="<?php the_permalink(); ?>">
                    <?php
                    $mainImage = get_post_meta(get_the_ID(), '_vds_product_mainimage', true);
                    if ($mainImage) : ?>
                        <div class="vds-product-image">
                            <img src="<?= esc_url($mainImage) ?>" alt="<?= esc_attr(get_the_title())?>" style="max-width:200px;">
                        </div>
                    <?php endif ?>
                    <h2><?php the_title(); ?></h2>
                    <?php 
                    $prijs = esc_html(get_post_meta(get_the_ID(), '_vds_prijs', true));
                    if (ctype_digit($prijs)) : ?>
                        <p class="vds-product-prijs">€<?php echo $prijs; ?></p>
                    <?php else : ?>
                        <p class="vds-product-prijs">Prijs op aanvraag</p>
                    <?php endif; ?>
                    <?php the_post_thumbnail('medium'); ?>
                    
                </a>
            </div>
        <?php endwhile; endif; ?>
    </div>
</div>

<?php
get_footer();
?>