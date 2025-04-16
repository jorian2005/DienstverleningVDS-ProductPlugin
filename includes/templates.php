<?php

function vds_template_override($template) {
    if (is_post_type_archive('vds_product')) {
        return VDS_PLUGIN_PATH . 'templates/archive-vds_product.php';
    }
    if (is_singular('vds_product')) {
        return VDS_PLUGIN_PATH . 'templates/single-vds_product.php';
    }
    return $template;
}
