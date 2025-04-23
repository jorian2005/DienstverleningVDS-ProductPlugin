<?php
if (!defined('ABSPATH')) exit;

add_action('admin_menu', function() {
    add_submenu_page(
        'options-general.php',
        'Plugin Updater',
        'Plugin Updater',
        'manage_options',
        'jb-plugin-updater',
        'jb_plugin_updater_page'
    );
});

function jb_plugin_updater_page() {
    ?>
    <div class="wrap">
        <h1>Plugin handmatig bijwerken</h1>
        <form method="post">
            <?php wp_nonce_field('jb_plugin_updater'); ?>
            <?php submit_button('Bijwerken vanaf GitHub'); ?>
        </form>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && check_admin_referer('jb_plugin_updater')) {
        jb_update_plugin_from_github();
    }
}

function jb_update_plugin_from_github() {

    function delete_directory($dir) {
        if (!is_dir($dir)) return;
            $items = array_diff(scandir($dir), array('.', '..'));
            foreach ($items as $item) {
                $path = $dir . DIRECTORY_SEPARATOR . $item;
                is_dir($path) ? delete_directory($path) : unlink($path);
            }
            rmdir($dir);
        }
        $download_url = 'https://github.com/jorian2005/DienstverleningVDS-ProductPlugin/archive/refs/heads/main.zip';
        $tmp_file = download_url($download_url);

    $target_dir = $extract_to . '/dienstverleningvds-productplugin';
    if (is_dir($target_dir)) {
        delete_directory($target_dir);
    }
    rename($extract_to . '/DienstverleningVDS-ProductPlugin-main', $target_dir);
    echo '<div class="notice notice-success"><p>Plugin succesvol bijgewerkt vanaf GitHub!</p></div>';

    $extract_to = WP_PLUGIN_DIR;
    $unzip_result = unzip_file($tmp_file, $extract_to);

    if (is_wp_error($unzip_result)) {
        echo '<div class="notice notice-error"><p>Fout bij uitpakken: ' . esc_html($unzip_result->get_error_message()) . '</p></div>';
    } else {
        rename($extract_to . '/DienstverleningVDS-ProductPlugin-main', $extract_to . '/dienstverleningvds-productplugin');
        echo '<div class="notice notice-success"><p>Plugin succesvol bijgewerkt vanaf GitHub!</p></div>';
    }

    @unlink($tmp_file);
}
