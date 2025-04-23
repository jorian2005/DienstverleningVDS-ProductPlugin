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
add_action('add_meta_boxes', 'vds_register_meta_boxes');

function vds_meta_box_callback($post) {
    wp_nonce_field('vds_product_save', 'vds_product_nonce');

    $prijs = get_post_meta($post->ID, '_vds_prijs', true);
    $images = get_post_meta($post->ID, '_vds_product_images', true);
    $hefhoogte = get_post_meta($post->ID, '_vds_hefhoogte', true);
    $doorrijdhoogte = get_post_meta($post->ID, '_vds_doorrijdhoogte', true);
    $draaiuren = get_post_meta($post->ID, '_vds_draaiuren', true);
    $bouwjaar = get_post_meta($post->ID, '_vds_bouwjaar', true);
    $lader = get_post_meta($post->ID, '_vds_lader', true);
    $accu = get_post_meta($post->ID, '_vds_accu', true);

    echo '<div style="margin-bottom:15px;">
            <button type="button" class="button tab-button active" data-tab="basis-tab">Basisgegevens</button>
            <button type="button" class="button tab-button" data-tab="specs-tab">Productspecificaties</button>
          </div>';

    echo '<div id="basis-tab" class="tab-content" style="display:block;">';
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
    echo '</div>';

    echo '<div id="specs-tab" class="tab-content" style="display:none;">';
    echo '<label for="vds_hefhoogte">Hefhoogte (m)</label>';
    echo '<input type="text" id="vds_hefhoogte" name="vds_hefhoogte" value="' . esc_attr($hefhoogte) . '" style="width:100%; margin-bottom:10px;">';

    echo '<label for="vds_doorrijdhoogte">Doorrijdhoogte (m)</label>';
    echo '<input type="text" id="vds_doorrijdhoogte" name="vds_doorrijdhoogte" value="' . esc_attr($doorrijdhoogte) . '" style="width:100%; margin-bottom:10px;">';

    echo '<label for="vds_draaiuren">Draaiuren</label>';
    echo '<input type="number" id="vds_draaiuren" name="vds_draaiuren" value="' . esc_attr($draaiuren) . '" style="width:100%; margin-bottom:10px;">';

    echo '<label for="vds_bouwjaar">Bouwjaar</label>';
    echo '<input type="number" id="vds_bouwjaar" name="vds_bouwjaar" value="' . esc_attr($bouwjaar) . '" style="width:100%; margin-bottom:10px;">';

    echo '<label for="vds_lader">Lader aanwezig?</label>';
    echo '<select id="vds_lader" name="vds_lader" style="width:100%; margin-bottom:10px;">';
    echo '<option value="ja"' . selected($lader, 'ja', false) . '>Ja</option>';
    echo '<option value="nee"' . selected($lader, 'nee', false) . '>Nee</option>';
    echo '</select>';

    echo '<label for="vds_accu">Accu</label>';
    echo '<input type="text" id="vds_accu" name="vds_accu" value="' . esc_attr($accu) . '" style="width:100%; margin-bottom:20px;">';
    echo '</div>';

    ?>
    <script>
    jQuery(document).ready(function($) {
        $('.tab-button').click(function() {
            $('.tab-button').removeClass('active');
            $(this).addClass('active');
            $('.tab-content').hide();
            $('#' + $(this).data('tab')).show();
        });

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
                    const html = `<li style="margin: 10px 0; display: inline-block; text-align: center; padding: 5px; border: 1px solid #ccc; border-radius: 5px;">
                        <img src="${url}" style="max-width:100px; display:block; margin: 0 auto 5px;">
                        <input type="hidden" name="vds_images[]" value="${url}">
                        <a href="#" class="vds_remove_image" style="display: block; color: red; text-decoration: none;">Verwijder</a>
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
    <style>
        .tab-button.active {
            background-color: #2271b1;
            color: white;
        }
    </style>
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

    $fields = [
        'vds_hefhoogte',
        'vds_doorrijdhoogte',
        'vds_draaiuren',
        'vds_bouwjaar',
        'vds_lader',
        'vds_accu'
    ];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'vds_save_meta_boxes');
