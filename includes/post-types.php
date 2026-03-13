<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function overedge_register_post_types() {

    // Testimonials
    register_post_type( 'testimonials', array(
        'labels' => array(
            'name'          => __( 'Testimonials', 'overedge' ),
            'singular_name' => __( 'Testimonial', 'overedge' ),
            'add_new_item'  => __( 'Add New Testimonial', 'overedge' ),
            'edit_item'     => __( 'Edit Testimonial', 'overedge' ),
        ),
        'public'       => true,
        'show_in_rest' => true,
        'rest_base'    => 'testimonials',
        'supports'     => array( 'title', 'editor', 'thumbnail' ),
        'menu_icon'    => 'dashicons-format-quote',
    ) );

    // Team Members
    register_post_type( 'team_members', array(
        'labels' => array(
            'name'          => __( 'Team Members', 'overedge' ),
            'singular_name' => __( 'Team Member', 'overedge' ),
            'add_new_item'  => __( 'Add New Team Member', 'overedge' ),
            'edit_item'     => __( 'Edit Team Member', 'overedge' ),
        ),
        'public'       => true,
        'show_in_rest' => true,
        'rest_base'    => 'team_members',
        'supports'     => array( 'title', 'editor', 'thumbnail' ),
        'menu_icon'    => 'dashicons-groups',
    ) );

    // FAQs
    register_post_type( 'faqs', array(
        'labels' => array(
            'name'          => __( 'FAQs', 'overedge' ),
            'singular_name' => __( 'FAQ', 'overedge' ),
            'add_new_item'  => __( 'Add New FAQ', 'overedge' ),
            'edit_item'     => __( 'Edit FAQ', 'overedge' ),
        ),
        'public'       => true,
        'show_in_rest' => true,
        'rest_base'    => 'faqs',
        'supports'     => array( 'title', 'editor' ),
        'menu_icon'    => 'dashicons-editor-help',
    ) );
}