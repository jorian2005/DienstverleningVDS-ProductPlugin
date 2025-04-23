<?php
function vds_add_viewport_meta_tag() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1">' . "\n";
}
add_action('wp_head', 'vds_add_viewport_meta_tag');
echo '<style>';
echo file_get_contents(VDS_PLUGIN_PATH . 'assets/css/single-product.css');
echo '</style>';
get_header();

$mainImage = get_post_meta(get_the_ID(), '_vds_product_mainimage', true);
$extraImages = get_post_meta(get_the_ID(), '_vds_product_images', true);
?>

<div class="vds-product-container container">
    <?php if ($mainImage || !empty($extraImages)) : ?>
        <div class="vds-product-images">
            <?php
            $allImages = [];
            if (!empty($mainImage)) {
                $allImages[] = $mainImage;
            }
            if (!empty($extraImages) && is_array($extraImages)) {
                $allImages = array_merge($allImages, $extraImages);
            }

            if (!empty($allImages[0])) {
                echo '<div class="vds-product-main-image"><img id="main-image" src="' . esc_url($allImages[0]) . '" 
                    onclick="openFullscreen(this.src)" alt="' . get_the_title() . '"></div>';
            }

            if (count($allImages) > 2) {
                echo '<div class="vds-product-thumbnail-images">';
                for ($i = 1; $i < count($allImages); $i++) {
                    echo '<img src="' . esc_url($allImages[$i]) . '" onclick="switchImage(this.src)" alt="' . get_the_title() . '"/>';
                }
                echo '</div>';
            }
            ?>
        </div>

        <script>
            var imageUrls = <?php echo json_encode($allImages); ?>;
            var currentIndex = 0;

            function switchImage(src) {
                var mainImage = document.getElementById('main-image');
                mainImage.src = src;
            }

            function openFullscreen(src) {
                currentIndex = imageUrls.indexOf(src);
                var fullscreenDiv = document.createElement('div');
                fullscreenDiv.classList.add('fullscreen');

                var img = document.createElement('img');
                img.classList.add('fullscreen-image');
                img.src = src;
                fullscreenDiv.appendChild(img);

                var prevButton = document.createElement('button');
                prevButton.classList.add('fullscreen-prev');
                prevButton.innerHTML = '&#10094;';
                prevButton.onclick = function (e) {
                    e.stopPropagation();
                    showImage(-1);
                };

                var nextButton = document.createElement('button');
                nextButton.classList.add('fullscreen-next');
                nextButton.innerHTML = '&#10095;';
                nextButton.onclick = function (e) {
                    e.stopPropagation();
                    showImage(1);
                };

                fullscreenDiv.appendChild(prevButton);
                fullscreenDiv.appendChild(nextButton);
                document.body.appendChild(fullscreenDiv);

                fullscreenDiv.onclick = function () {
                    document.body.removeChild(fullscreenDiv);
                };

                document.addEventListener('keydown', function escListener(e) {
                    if (e.key === 'Escape') {
                        document.body.removeChild(fullscreenDiv);
                        document.removeEventListener('keydown', escListener);
                    }
                });

                let touchStartX = 0;
                let touchEndX = 0;

                img.addEventListener('touchstart', function (e) {
                    touchStartX = e.changedTouches[0].screenX;
                });

                img.addEventListener('touchend', function (e) {
                    touchEndX = e.changedTouches[0].screenX;
                    handleGesture();
                });

                function handleGesture() {
                    const threshold = 50;
                    if (touchEndX < touchStartX - threshold) {
                        showImage(1);
                    } else if (touchEndX > touchStartX + threshold) {
                        showImage(-1);
                    }
                }

                function showImage(direction) {
                    currentIndex = (currentIndex + direction + imageUrls.length) % imageUrls.length;
                    img.src = imageUrls[currentIndex];
                }
            }
        </script>

    <?php endif; ?>

    <div class="vds-product-info">
        <h1><?php the_title(); ?></h1>
        <?php 
        $prijs = esc_html(get_post_meta(get_the_ID(), '_vds_prijs', true));
        $hefhoogte = esc_html(get_post_meta(get_the_ID(), '_vds_hefhoogte', true));
        $doorrijdhoogte = esc_html(get_post_meta(get_the_ID(), '_vds_doorrijdhoogte', true));
        $draaiuren = esc_html(get_post_meta(get_the_ID(), '_vds_draaiuren', true));
        $bouwjaar = esc_html(get_post_meta(get_the_ID(), '_vds_bouwjaar', true));
        $lader = esc_html(get_post_meta(get_the_ID(), '_vds_lader', true));
        $accu = esc_html(get_post_meta(get_the_ID(), '_vds_accu', true));


        if (ctype_digit($prijs)) : ?>
            <p class="vds-product-prijs">€<?php echo $prijs; ?></p>
        <?php else : ?>
            <p class="vds-product-prijs">Prijs op aanvraag</p>
        <?php endif;
        ?> <div class="vds-product-details"> <?php
        if (!empty($hefhoogte)) {
            echo '<p class="vds-product-hefhoogte"><b>Hefhoogte:</b> ' . $hefhoogte . '</p>';
        }
        if (!empty($doorrijdhoogte)) {
            echo '<p class="vds-product-doorrijdhoogte"><b>Doorrijdhoogte:</b> ' . $doorrijdhoogte . '</p>';
        }
        if (!empty($draaiuren)) {
            echo '<p class="vds-product-draaiuren"><b>Draaiuren:</b> ' . $draaiuren . '</p>';
        }
        if (!empty($bouwjaar)) {
            echo '<p class="vds-product-bouwjaar"><b>Bouwjaar:</b> ' . $bouwjaar . '</p>';
        }
        if (!empty($lader)) {
            echo '<p class="vds-product-lader"><b>Lader:</b> ' . $lader . '</p>';
        }
        if (!empty($accu)) {
            echo '<p class="vds-product-accu"><b>Accu:</b> ' . $accu . '</p>';
        }
        ?>
        </div>
        <div class="vds-omschrijving"><?php the_content(); ?></div>
        <div class="vds-product-buttons">
            <a href="/contact/" class="vds-button">Neem contact op</a>
        </div>
    </div>
</div>

<?php
get_footer();
?>