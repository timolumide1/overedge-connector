<?php
/**
 * Plugin Name: Overedge Connector
 * Plugin URI:  https://overedge.dev/connector
 * Description: Connects your WordPress site to a Lovable-built React frontend as a headless CMS.
 * Version:     1.0.1
 * Author:      Overedge
 * Author URI:  https://overedge.dev
 * License:     GPL v2 or later
 * Text Domain: overedge-connector
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Plugin constants
define( 'OVERCO_VERSION', '1.0.1' );
define( 'OVERCO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'OVERCO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Load modules
require_once OVERCO_PLUGIN_DIR . 'includes/activator.php';
require_once OVERCO_PLUGIN_DIR . 'includes/post-types.php';
require_once OVERCO_PLUGIN_DIR . 'includes/acf-fields.php';
require_once OVERCO_PLUGIN_DIR . 'includes/cors.php';
require_once OVERCO_PLUGIN_DIR . 'includes/options.php';
require_once OVERCO_PLUGIN_DIR . 'includes/health.php';

// Activation hook
register_activation_hook( __FILE__, 'overco_activate' );

// Initialise all modules
add_action( 'init', 'overedge_register_post_types' );
add_action( 'init', 'overedge_register_acf_fields' );
add_action( 'init', 'overco_maybe_flush_rewrite_rules', 99 );
add_filter( 'query_vars', 'overco_add_query_vars' );
add_action( 'rest_api_init', 'overco_register_health_endpoint', 0 );
add_action( 'rest_api_init', 'overco_register_options_endpoint', 0 );
add_filter( 'rest_pre_serve_request', 'overco_handle_cors' );
add_action( 'init', 'overco_register_acf_options_page' );
add_action( 'template_redirect', 'overco_health_query_var_fallback' );
