<?php

/**
 * Plugin Name: WPGraphQL Gatsby Preview
 * Plugin URI: https://github.com/CalebBarnes/
 * Description: Replaces the post preview button & adds an iframe template to your front end url.
 * Version: 0.1
 * Author: Caleb Barnes
 * Author URI: https://github.com/CalebBarnes/
 */


require_once(plugin_dir_path(__FILE__) . 'includes/console_log.php');

/* Template Include */
add_filter('template_include', 'gatsby_preview_template_include', 1, 1);
function gatsby_preview_template_include($template)
{
    $is_preview  = is_preview();
    console_log($is_preview);

    if ($is_preview) {
        return plugin_dir_path(__FILE__) . 'includes/preview-template.php'; //Load your template or file
    }

    return $template;
}
