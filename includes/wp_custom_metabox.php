<?php
//add_action( 'cmb2_admin_init', 'telecurazao_register_demo_metabox' );
//function telecurazao_register_demo_metabox() {
//    $prefix = 'telecurazao_';
//
//    $cmb_metabox = new_cmb2_box( array(
//        'id'            => $prefix . 'metabox',
//        'title'         => esc_html__( 'Test Metabox', 'cmb2' ),
//        'object_types'  => array( 'page' ), // Post type
//        // 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
//        // 'context'    => 'normal',
//        // 'priority'   => 'high',
//        // 'show_names' => true, // Show field names on the left
//        // 'cmb_styles' => false, // false to disable the CMB stylesheet
//        // 'closed'     => true, // true to keep the metabox closed by default
//        // 'classes'    => 'extra-class', // Extra cmb2-wrap classes
//        // 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
//    ) );
//
//    $cmb_metabox->add_field( array(
//        'name'       => esc_html__( 'Test Text', 'cmb2' ),
//        'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
//        'id'         => $prefix . 'text',
//        'type'       => 'text',
//        'show_on_cb' => 'yourprefix_hide_if_no_cats', // function should return a bool value
//        // 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
//        // 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
//        // 'on_front'        => false, // Optionally designate a field to wp-admin only
//        // 'repeatable'      => true,
//        // 'column'          => true, // Display field value in the admin post-listing columns
//    ) );
//}
