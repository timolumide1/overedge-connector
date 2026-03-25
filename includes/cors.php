<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Whether the current request targets this plugin's REST surfaces (scoped CORS).
 */
function overedge_request_should_receive_connector_cors() {
    if ( empty( $_SERVER['REQUEST_URI'] ) ) {
        return false;
    }

    $path = sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) );

    if ( false !== stripos( $path, 'overedge' ) ) {
        return true;
    }

    if ( 1 === preg_match( '#wp-json/wp/v2/(testimonials|team_members|faqs)(/|$|\?)#i', $path ) ) {
        return true;
    }

    // Custom namespace and health fallback.
    if ( false !== stripos( $path, 'overedge/v1' ) || false !== stripos( $path, 'overedge-health' ) ) {
        return true;
    }

    // JSON health fallback via query var (cross-origin fetch needs headers).
    if ( false !== stripos( $path, 'overedge_health' ) ) {
        return true;
    }

    return false;
}

function overco_handle_cors( $served ) {
    if ( ! overedge_request_should_receive_connector_cors() ) {
        return $served;
    }

    $origin = isset( $_SERVER['HTTP_ORIGIN'] )
        ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_ORIGIN'] ) )
        : '';

    $allowed_origin = get_option( 'overedge_allowed_origin', '' );

    if ( empty( $allowed_origin ) ) {
        $access_control_origin = '*';
    } elseif ( ! empty( $origin ) && hash_equals( $allowed_origin, $origin ) ) {
        $access_control_origin = $origin;
    } else {
        $access_control_origin = $allowed_origin;
    }

    header( 'Access-Control-Allow-Origin: ' . $access_control_origin );
    header( 'Access-Control-Allow-Methods: GET, POST, OPTIONS' );
    header( 'Access-Control-Allow-Headers: Authorization, Content-Type, X-WP-Nonce, X-Overco-Secret, X-Overedge-Secret' );
    header( 'Access-Control-Allow-Credentials: true' );

    $request_method = isset( $_SERVER['REQUEST_METHOD'] )
        ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) )
        : '';

    if ( 'OPTIONS' === $request_method ) {
        header( 'HTTP/1.1 200 OK' );
        exit();
    }

    return $served;
}
