<?php
add_action( 'cmb2_admin_init', 'telecurazao_register_demo_metabox' );
function telecurazao_register_demo_metabox() {
    $prefix = 'telecurazao_';

    $cmb_metabox = new_cmb2_box( array(
        'id'            => $prefix . 'metabox',
        'title'         => esc_html__( 'Product Info', 'telecurazao' ),
        'object_types'  => array( 'product' ), // Post type
        // 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
        // 'context'    => 'normal',
        // 'priority'   => 'high',
        // 'show_names' => true, // Show field names on the left
        // 'cmb_styles' => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // true to keep the metabox closed by default
        // 'classes'    => 'extra-class', // Extra cmb2-wrap classes
        // 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
    ) );

    $cmb_metabox->add_field( array(
        'name'       => esc_html__( 'Remove Duration of Commercial', 'telecurazao' ),
        'desc'       => esc_html__( 'Check if you want to remove "Comercial Duration"', 'telecurazao' ),
        'id'         => $prefix . 'product_no_options',
        'type'       => 'checkbox'
    ) );
}
