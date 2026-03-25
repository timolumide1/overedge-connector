<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function overedge_register_acf_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    // Testimonials field group
    acf_add_local_field_group( array(
        'key'      => 'group_overedge_testimonials',
        'title'    => 'Testimonial Fields',
        'fields'   => array(
            array(
                'key'   => 'field_overedge_quote',
                'label' => 'Quote',
                'name'  => 'quote',
                'type'  => 'textarea',
            ),
            array(
                'key'   => 'field_overedge_author_name',
                'label' => 'Author Name',
                'name'  => 'author_name',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_overedge_author_country',
                'label' => 'Author Country',
                'name'  => 'author_country',
                'type'  => 'text',
            ),
            array(
                'key'     => 'field_overedge_destination',
                'label'   => 'Destination',
                'name'    => 'destination',
                'type'    => 'select',
                'choices' => array(
                    'germany' => 'Germany',
                    'usa'     => 'United States',
                    'both'    => 'Both',
                ),
            ),
            array(
                'key'           => 'field_overedge_avatar',
                'label'         => 'Avatar / Photo',
                'name'          => 'avatar',
                'type'          => 'image',
                'return_format' => 'url',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'overedge_testimonials',
                ),
            ),
        ),
        'show_in_rest' => true,
    ) );

    // Team Members field group
    acf_add_local_field_group( array(
        'key'      => 'group_overedge_team_members',
        'title'    => 'Team Member Fields',
        'fields'   => array(
            array(
                'key'   => 'field_overedge_full_name',
                'label' => 'Full Name',
                'name'  => 'full_name',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_overedge_job_title',
                'label' => 'Job Title',
                'name'  => 'job_title',
                'type'  => 'text',
            ),
            array(
                'key'   => 'field_overedge_bio',
                'label' => 'Bio',
                'name'  => 'bio',
                'type'  => 'textarea',
            ),
            array(
                'key'           => 'field_overedge_photo',
                'label'         => 'Photo',
                'name'          => 'photo',
                'type'          => 'image',
                'return_format' => 'url',
            ),
            array(
                'key'     => 'field_overedge_destination_focus',
                'label'   => 'Destination Focus',
                'name'    => 'destination_focus',
                'type'    => 'select',
                'choices' => array(
                    'germany' => 'Germany',
                    'usa'     => 'United States',
                    'both'    => 'Both',
                ),
            ),
            array(
                'key'   => 'field_overedge_linkedin_url',
                'label' => 'LinkedIn URL',
                'name'  => 'linkedin_url',
                'type'  => 'url',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'overedge_team_members',
                ),
            ),
        ),
        'show_in_rest' => true,
    ) );

    // FAQs field group
    acf_add_local_field_group( array(
        'key'      => 'group_overedge_faqs',
        'title'    => 'FAQ Fields',
        'fields'   => array(
            array(
                'key'   => 'field_overedge_answer',
                'label' => 'Answer',
                'name'  => 'answer',
                'type'  => 'textarea',
            ),
            array(
                'key'     => 'field_overedge_faq_destination',
                'label'   => 'Destination',
                'name'    => 'destination',
                'type'    => 'select',
                'choices' => array(
                    'germany' => 'Germany',
                    'usa'     => 'United States',
                    'both'    => 'Both',
                ),
            ),
            array(
                'key'           => 'field_overedge_order',
                'label'         => 'Order',
                'name'          => 'order',
                'type'          => 'number',
                'default_value' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'overedge_faqs',
                ),
            ),
        ),
        'show_in_rest' => true,
    ) );
}
