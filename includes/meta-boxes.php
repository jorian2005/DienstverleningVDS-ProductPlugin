<?php
function vds_register_meta_boxes() {
    add_meta_box(
        'vds_product_meta',
        'Productinformatie',
        'vds_meta_box_callback',
        'vds_product',
        'normal',
        'default'
    );
}

function vds_meta_box_callback($post) {
    wp_nonce_field('vds_product_save', 'vds_product_nonce');

    $prijs = get_post_meta($post->ID, '_vds_prijs', true);
    $images = get_post_meta($post->ID, '_vds_product_images', true);

    echo '<label for="vds_prijs">Prijs (€)</label>';
    echo '<input type="text" id="vds_prijs" name="vds_prijs" value="' . esc_attr($prijs) . '" style="width:100%; margin-bottom:20px;">';

    echo '<h4>Meerdere Afbeeldingen</h4>';
    echo '<button type="button" class="button" id="vds_add_images">Afbeeldingen toevoegen</button>';
    echo '<ul id="vds_image_list" style="list-style: none; padding: 0; gap: 10px; display: flex; flex-wrap: wrap;">';
    if (!empty($images) && is_array($images)) {
        foreach ($images as $img_url) {
            echo '<li style="margin: 10px 0; display: inline-block; text-align: center; padding: 5px; border: 1px solid #ccc; border-radius: 5px;">';
            echo '<img src="' . esc_url($img_url) . '" style="max-width:100px; display: block; margin: 0 auto 5px;">';
            echo '<input type="hidden" name="vds_images[]" value="' . esc_attr($img_url) . '">';
            echo '<a href="#" class="vds_remove_image" style="display: block; color: red; text-decoration: none;">Verwijder</a>';
            echo '</li>';
        }
    }
    echo '</ul>';

    ?>
    <script>
    jQuery(document).ready(function($) {
        let frame;
        $('#vds_add_images').on('click', function(e) {
            e.preventDefault();
            if (frame) {
                frame.open();
                return;
            }
            frame = wp.media({
                title: 'Selecteer afbeeldingen',
                button: { text: 'Toevoegen' },
                multiple: true
            });

            frame.on('select', function() {
                const selection = frame.state().get('selection');
                selection.each(function(attachment) {
                    const url = attachment.attributes.url;
                    const html = `<li style="margin: 10px 0;">
                        <img src="${url}" style="max-width:100px; margin-right:10px;">
                        <input type="hidden" name="vds_images[]" value="${url}">
                        <a href="#" class="vds_remove_image">Verwijder</a>
                    </li>`;
                    $('#vds_image_list').append(html);
                });
            });

            frame.open();
        });

        $('#vds_image_list').on('click', '.vds_remove_image', function(e) {
            e.preventDefault();
            $(this).closest('li').remove();
        });
    });
    </script>
    <?php
}

function vds_save_meta_boxes($post_id) {
    if (!isset($_POST['vds_product_nonce']) || !wp_verify_nonce($_POST['vds_product_nonce'], 'vds_product_save')) {
        return;
    }

    if (isset($_POST['vds_prijs'])) {
        update_post_meta($post_id, '_vds_prijs', sanitize_text_field($_POST['vds_prijs']));
    }

    if (isset($_POST['vds_images']) && is_array($_POST['vds_images'])) {
        $images = array_map('esc_url_raw', $_POST['vds_images']);
        update_post_meta($post_id, '_vds_product_images', $images);

        if (!empty($images[0])) {
            update_post_meta($post_id, '_vds_product_mainimage', $images[0]);
        }
    } else {
        delete_post_meta($post_id, '_vds_product_images');
        delete_post_meta($post_id, '_vds_product_mainimage');
    }
}

