<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Copy overco_* options to overedge_* when missing, then remove overco_*.
 */
function overco_migrate_legacy_options() {
    $pairs = array(
        'overco_version'             => 'overedge_version',
        'overco_allowed_origin'      => 'overedge_allowed_origin',
        'overco_secret_key'          => 'overedge_secret_key',
        'overco_flush_rewrite_rules' => 'overedge_flush_rewrite_rules',
    );

    foreach ( $pairs as $old_key => $new_key ) {
        $old_val = get_option( $old_key, '__unset__' );
        $new_val = get_option( $new_key, '__unset__' );

        if ( '__unset__' === $new_val && '__unset__' !== $old_val ) {
            update_option( $new_key, $old_val );
        }

        delete_option( $old_key );
    }
}

function overco_activate() {
    overco_migrate_legacy_options();

    update_option( 'overedge_version', OVERCO_VERSION );

    if ( '__unset__' === get_option( 'overedge_allowed_origin', '__unset__' ) ) {
        update_option( 'overedge_allowed_origin', '' );
    }

    if ( '__unset__' === get_option( 'overedge_secret_key', '__unset__' ) ) {
        update_option( 'overedge_secret_key', wp_generate_password( 32, false ) );
    }

    flush_rewrite_rules();

    update_option( 'overedge_flush_rewrite_rules', '1' );
}

/**
 * Flush rewrite rules once after activation so REST API routes are available.
 */
function overco_maybe_flush_rewrite_rules() {
    if ( get_option( 'overedge_flush_rewrite_rules' ) ) {
        delete_option( 'overedge_flush_rewrite_rules' );
        flush_rewrite_rules();
    }
}
