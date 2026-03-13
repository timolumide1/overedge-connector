<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function overedge_activate() {
    // Store plugin version on activation
    update_option( 'overedge_version', OVEREDGE_VERSION );

    // Store the allowed origin (React frontend URL)
    // This gets updated via the REST API after connection
    if ( ! get_option( 'overedge_allowed_origin' ) ) {
        update_option( 'overedge_allowed_origin', '' );
    }

    // Store the Overedge secret key for webhook verification
    if ( ! get_option( 'overedge_secret_key' ) ) {
        update_option( 'overedge_secret_key', wp_generate_password( 32, false ) );
    }

    // Flush rewrite rules so custom post type and REST API routes work
    flush_rewrite_rules();

    // Schedule a second flush on next load (REST routes need permalinks to be ready)
    update_option( 'overedge_flush_rewrite_rules', '1' );
}

/**
 * Flush rewrite rules once after activation so REST API routes are available.
 */
function overedge_maybe_flush_rewrite_rules() {
    if ( get_option( 'overedge_flush_rewrite_rules' ) ) {
        delete_option( 'overedge_flush_rewrite_rules' );
        flush_rewrite_rules();
    }
}