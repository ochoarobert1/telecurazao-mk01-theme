<?php

//function portafolio() {
//
//    $labels = array(
//        'name'                  => _x( 'Portafolios', 'Post Type General Name', 'telecurazao' ),
//        'singular_name'         => _x( 'Portafolio', 'Post Type Singular Name', 'telecurazao' ),
//        'menu_name'             => __( 'Portafolio', 'telecurazao' ),
//        'name_admin_bar'        => __( 'Portafolio', 'telecurazao' ),
//        'archives'              => __( 'Archivo de Portafolio', 'telecurazao' ),
//        'attributes'            => __( 'Atributos de Portafolio', 'telecurazao' ),
//        'parent_item_colon'     => __( 'Portafolio Padre:', 'telecurazao' ),
//        'all_items'             => __( 'Todos los Items', 'telecurazao' ),
//        'add_new_item'          => __( 'Agregar Nuevo Item', 'telecurazao' ),
//        'add_new'               => __( 'Agregar Nuevo', 'telecurazao' ),
//        'new_item'              => __( 'Nuevo Item', 'telecurazao' ),
//        'edit_item'             => __( 'Editar Item', 'telecurazao' ),
//        'update_item'           => __( 'Actualizar Item', 'telecurazao' ),
//        'view_item'             => __( 'Ver Item', 'telecurazao' ),
//        'view_items'            => __( 'Ver Portafolio', 'telecurazao' ),
//        'search_items'          => __( 'Buscar en Portafolio', 'telecurazao' ),
//        'not_found'             => __( 'No hay Resultados', 'telecurazao' ),
//        'not_found_in_trash'    => __( 'No hay Resultados en la Papelera', 'telecurazao' ),
//        'featured_image'        => __( 'Imagen Destacada', 'telecurazao' ),
//        'set_featured_image'    => __( 'Colocar Imagen Destacada', 'telecurazao' ),
//        'remove_featured_image' => __( 'Remover Imagen Destacada', 'telecurazao' ),
//        'use_featured_image'    => __( 'Usar como Imagen Destacada', 'telecurazao' ),
//        'insert_into_item'      => __( 'Insertar dentro de Item', 'telecurazao' ),
//        'uploaded_to_this_item' => __( 'Cargado a este item', 'telecurazao' ),
//        'items_list'            => __( 'Listado del Portafolio', 'telecurazao' ),
//        'items_list_navigation' => __( 'Navegación de Listado del Portafolio', 'telecurazao' ),
//        'filter_items_list'     => __( 'Filtro de Listado del Portafolio', 'telecurazao' ),
//    );
//    $args = array(
//        'label'                 => __( 'Portafolio', 'telecurazao' ),
//        'description'           => __( 'Portafolio de Desarrollos', 'telecurazao' ),
//        'labels'                => $labels,
//        'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'comments', 'trackbacks', 'custom-fields', ),
//        'taxonomies'            => array( 'custom_portafolio' ),
//        'hierarchical'          => false,
//        'public'                => true,
//        'show_ui'               => true,
//        'show_in_menu'          => true,
//        'menu_position'         => 5,
//        'menu_icon'             => 'dashicons-testimonial',
//        'show_in_admin_bar'     => true,
//        'show_in_nav_menus'     => true,
//        'can_export'            => true,
//        'has_archive'           => true,
//        'exclude_from_search'   => false,
//        'publicly_queryable'    => true,
//        'capability_type'       => 'post',
//        'show_in_rest'          => true,
//    );
//    register_post_type( 'portafolio', $args );
//
//}
//add_action( 'init', 'portafolio', 0 );
