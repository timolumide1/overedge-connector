<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

delete_option( 'overedge_version' );
delete_option( 'overedge_allowed_origin' );
delete_option( 'overedge_secret_key' );
delete_option( 'overedge_flush_rewrite_rules' );

delete_option( 'overco_version' );
delete_option( 'overco_allowed_origin' );
delete_option( 'overco_secret_key' );
delete_option( 'overco_flush_rewrite_rules' );
