<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function overedge_register_acf_options_page() {
    // Only register if ACF Pro is active
    if ( ! function_exists( 'acf_add_options_page' ) ) {
        return;
    }

    acf_add_options_page( array(
        'page_title' => 'Site Settings',
        'menu_title' => 'Site Settings',
        'menu_slug'  => 'overedge-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
        'icon_url'   => 'dashicons-admin-site-alt3',
    ) );
}

function overedge_register_options_endpoint() {
    // Endpoint to update allowed origin after connection
    register_rest_route( 'overedge/v1', '/configure', array(
        'methods'             => 'POST',
        'callback'            => 'overedge_configure',
        'permission_callback' => 'overedge_verify_secret',
    ) );

    // Endpoint to get site-wide settings
    register_rest_route( 'overedge/v1', '/settings', array(
        'methods'             => 'GET',
        'callback'            => 'overedge_get_settings',
        'permission_callback' => '__return_true',
    ) );
}

function overedge_verify_secret( $request ) {
    $secret = $request->get_header( 'X-Overedge-Secret' );
    $stored = get_option( 'overedge_secret_key', '' );
    return ! empty( $stored ) && hash_equals( $stored, $secret );
}

function overedge_configure( $request ) {
    $params = $request->get_json_params();

    if ( ! empty( $params['allowed_origin'] ) ) {
        update_option( 'overedge_allowed_origin', 
            esc_url_raw( $params['allowed_origin'] ) );
    }

    return rest_ensure_response( array(
        'success'        => true,
        'allowed_origin' => get_option( 'overedge_allowed_origin' ),
        'message'        => 'Overedge configuration updated successfully.',
    ) );
}

function overedge_get_settings() {
    // Returns site-wide CMS settings for the React frontend
    return rest_ensure_response( array(
        'site_name'    => get_bloginfo( 'name' ),
        'site_url'     => get_site_url(),
        'hero_headline'    => get_field( 'hero_headline',    'option' ) ?: '',
        'hero_subheadline' => get_field( 'hero_subheadline', 'option' ) ?: '',
        'stats_students'   => get_field( 'stats_students',   'option' ) ?: '',
        'stats_destinations' => get_field( 'stats_destinations', 'option' ) ?: '',
        'consulting_cta'   => get_field( 'consulting_cta',   'option' ) ?: '',
        'contact_email'    => get_field( 'contact_email',    'option' ) ?: '',
        'contact_whatsapp' => get_field( 'contact_whatsapp', 'option' ) ?: '',
    ) );
}