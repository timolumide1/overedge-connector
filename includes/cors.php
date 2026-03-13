<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function overedge_handle_cors( $served ) {
    $allowed_origin = get_option( 'overedge_allowed_origin', '' );

    // If no origin set yet, allow all during setup
    if ( empty( $allowed_origin ) ) {
        $origin = '*';
    } else {
        $origin = $allowed_origin;
    }

    header( 'Access-Control-Allow-Origin: ' . $origin );
    header( 'Access-Control-Allow-Methods: GET, POST, OPTIONS' );
    header( 'Access-Control-Allow-Headers: Authorization, Content-Type, X-WP-Nonce' );
    header( 'Access-Control-Allow-Credentials: true' );

    // Handle preflight OPTIONS request
    if ( isset( $_SERVER['REQUEST_METHOD'] ) && 
         $_SERVER['REQUEST_METHOD'] === 'OPTIONS' ) {
        header( 'HTTP/1.1 200 OK' );
        exit();
    }

    return $served;
}