<?php

function telecurazao_sales_agents() {

    $labels = array(
        'name'                  => _x( 'Sale Agents', 'Post Type General Name', 'telecurazao' ),
        'singular_name'         => _x( 'Sales Agent', 'Post Type Singular Name', 'telecurazao' ),
        'menu_name'             => __( 'Sales Agents', 'telecurazao' ),
        'name_admin_bar'        => __( 'Sales Agents', 'telecurazao' ),
        'archives'              => __( 'Sales Agents Archives', 'telecurazao' ),
        'attributes'            => __( 'Sales Agent Attributes', 'telecurazao' ),
        'parent_item_colon'     => __( 'Sales Agent Item:', 'telecurazao' ),
        'all_items'             => __( 'All Sales Agents', 'telecurazao' ),
        'add_new_item'          => __( 'Add New Sales Agent', 'telecurazao' ),
        'add_new'               => __( 'Add New', 'telecurazao' ),
        'new_item'              => __( 'New Sales Agent', 'telecurazao' ),
        'edit_item'             => __( 'Edit Sales Agent', 'telecurazao' ),
        'update_item'           => __( 'Update Sales Agent', 'telecurazao' ),
        'view_item'             => __( 'View Sales Agent', 'telecurazao' ),
        'view_items'            => __( 'View Sales Agents', 'telecurazao' ),
        'search_items'          => __( 'Search Sales Agent', 'telecurazao' ),
        'not_found'             => __( 'Not found', 'telecurazao' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'telecurazao' ),
        'featured_image'        => __( 'Featured Image', 'telecurazao' ),
        'set_featured_image'    => __( 'Set featured image', 'telecurazao' ),
        'remove_featured_image' => __( 'Remove featured image', 'telecurazao' ),
        'use_featured_image'    => __( 'Use as featured image', 'telecurazao' ),
        'insert_into_item'      => __( 'Insert into Sales Agent', 'telecurazao' ),
        'uploaded_to_this_item' => __( 'Uploaded to this Sales Agent', 'telecurazao' ),
        'items_list'            => __( 'Sales Agents list', 'telecurazao' ),
        'items_list_navigation' => __( 'Sales Agents list navigation', 'telecurazao' ),
        'filter_items_list'     => __( 'Filter Sales Agents list', 'telecurazao' ),
    );
    $args = array(
        'label'                 => __( 'Sales Agent', 'telecurazao' ),
        'description'           => __( 'Sales Agents for Telecuraçao', 'telecurazao' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-groups',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'show_in_rest'          => true,
    );
    register_post_type( 'sales-agents', $args );

}
add_action( 'init', 'telecurazao_sales_agents', 0 );
