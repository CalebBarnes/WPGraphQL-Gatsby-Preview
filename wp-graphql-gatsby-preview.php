<?php

/**
 * Plugin Name: WPGraphQL Gatsby Preview
 * Plugin URI: https://github.com/CalebBarnes/
 * Description: Replaces the post preview button & adds an iframe template to your front end url.
 * Version: 0.1
 * Author: Caleb Barnes
 * Author URI: https://github.com/CalebBarnes/
 */


require_once(plugin_dir_path( __FILE__ ) . 'includes/post-preview-button.php');

/* Query Vars */
add_filter( 'query_vars', 'add_preview_query_vars' );
function add_preview_query_vars( $vars ) {
    $vars[] = 'preview';
    return $vars;
}

/* Rewrite Rules */
add_action('init', 'gatsby_preview_rewrite_rules');
function gatsby_preview_rewrite_rules() {
    add_rewrite_rule( 'preview/?$', 'index.php?preview=true', 'top' );
}

/* Template Include */
add_filter('template_include', 'gatsby_preview_template_include', 1, 1); 
function gatsby_preview_template_include($template)
{
    global $wp_query; //Load $wp_query object
    $page_value = $wp_query->query_vars['preview']; //Check for query var "preview"

    if ($page_value && $page_value == "true") { //Verify "preview" exists and value is "true".
        return plugin_dir_path(__FILE__) . 'includes/preview-template.php'; //Load your template or file
    }

    return $template; //Load normal template when $page_value != "true" as a fallback
}

?>