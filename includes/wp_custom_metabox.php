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

    $cmb_metabox->add_field( array(
        'name' => esc_html__( 'Product Custom Fees', 'telecurazao' ),
        'desc' => esc_html__( 'Use this if you want to add several Product Custom Fees', 'telecurazao' ),
        'type' => 'title',
        'id'   => 'wiki_test_title'
    ) );

    $group_field_id = $cmb_metabox->add_field( [
        'id'      => $prefix . 'custom_fees',
        'type'    => 'group',
        'options' => [ 'sortable' => false ]
    ] );

    $cmb_metabox->add_group_field( $group_field_id, [
        'name' => esc_html__( 'Product Custom Fees', 'telecurazao' ),
        'desc' => esc_html__( 'Use this if you want to add several Product Custom Fees', 'telecurazao' ),
        'type' => 'title',
        'id'   => 'wiki_test_title'
    ] );

    $cmb_metabox->add_group_field( $group_field_id, [
        'name'         => 'Label of Fee',
        'id'           => $prefix . 'fee_label',
        'type'         => 'text'
    ] );

    $cmb_metabox->add_group_field( $group_field_id, [
        'name'         => 'Price of Fee',
        'id'           => $prefix . 'fee_price',
        'type'         => 'text_money',
    ] );
}

/**
 * Register meta box(es).
 */
function wpdocs_register_meta_boxes() {
    add_meta_box( 'jsontelemetabox', __( 'Generate JSON file', 'telecuracao' ), 'wpdocs_my_display_callback', 'shop_order', 'side' );
}
add_action( 'add_meta_boxes', 'wpdocs_register_meta_boxes' );

function wpdocs_my_display_callback( $post ) {
?>
<div>
    <h4>Generate file for external custom service</h4>
    <button data-order_id="<?php echo get_the_ID(); ?>" class="button btn-json-file">Generate JSON File</button>
    <div class="response-json-file"></div>
    <a href="" class="hidden-click hidden"></a>
</div>
<?php 
                                             }
