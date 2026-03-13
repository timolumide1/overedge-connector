<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function overedge_register_health_endpoint() {
    $args = array(
        'methods'             => 'GET',
        'callback'            => 'overedge_health_check',
        'permission_callback' => '__return_true',
    );
    register_rest_route( 'overedge/v1', '/health', $args );
    // Fallback under wp/v2 in case custom namespace is blocked (e.g. by host/security plugin)
    register_rest_route( 'wp/v2', '/overedge-health', $args );
}

function overedge_add_query_vars( $vars ) {
    $vars[] = 'overedge_health';
    return $vars;
}

/**
 * If REST API routes are blocked (e.g. by host/security), health check via query var.
 * Use: https://yoursite.com/?overedge_health=1
 */
function overedge_health_query_var_fallback() {
    if ( ! get_query_var( 'overedge_health' ) ) {
        return;
    }
    $data = overedge_health_check();
    if ( $data instanceof WP_REST_Response ) {
        $data = $data->get_data();
    }
    status_header( 200 );
    header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
    echo wp_json_encode( $data );
    exit;
}

function overedge_health_check() {
    global $wpdb;

    // Count content
    $post_count        = wp_count_posts( 'post' );
    $testimonial_count = wp_count_posts( 'testimonials' );
    $team_count        = wp_count_posts( 'team_members' );
    $faq_count         = wp_count_posts( 'faqs' );

    return rest_ensure_response( array(
        'status'          => 'ok',
        'plugin_version'  => OVEREDGE_VERSION,
        'wordpress_version' => get_bloginfo( 'version' ),
        'site_name'       => get_bloginfo( 'name' ),
        'site_url'        => get_site_url(),
        'allowed_origin'  => get_option( 'overedge_allowed_origin', '' ),
        'secret_key_set'  => ! empty( get_option( 'overedge_secret_key' ) ),
        'post_types'      => array(
            'posts'        => (int) $post_count->publish,
            'testimonials' => (int) $testimonial_count->publish,
            'team_members' => (int) $team_count->publish,
            'faqs'         => (int) $faq_count->publish,
        ),
        'rest_api_url'    => get_rest_url(),
        'timestamp'       => current_time( 'c' ),
    ) );
}