<?php
/* WOOCOMMERCE CUSTOM COMMANDS */

/* WOOCOMMERCE - DECLARE THEME SUPPORT - BEGIN */
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
/* WOOCOMMERCE - DECLARE THEME SUPPORT - END */

/* WOOCOMMERCE - CUSTOM WRAPPER - BEGIN */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

function my_theme_wrapper_start() {
    echo '<section id="main" class="container"><div class="row"><div class="woocustom-main-container col-12">';
}

function my_theme_wrapper_end() {
    echo '</div></div></section>';
}
/* WOOCOMMERCE - CUSTOM WRAPPER - END */

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);


remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);


/* --------------------------------------------------------------
ADD PRICE IN FLORINS
-------------------------------------------------------------- */

add_action('woocommerce_custom_price', 'woocommerce_custom_price_converter');

function woocommerce_custom_price_converter() {
    global $product;
    $tax_rate = 1.8;
    $price_dollars = $product->get_price();
    $price_florins = $price_dollars * $tax_rate;
    echo ' | ƒ ' . number_format((float)$price_florins, 2, '.', '');
}

/* --------------------------------------------------------------
ADD CUSTOM FIELD TO PRODUCT SINGLE - DYNAMIC CONTENT
-------------------------------------------------------------- */

add_action('woocommerce_before_add_to_cart_button', 'custom_woocommerce_fee_fields');

function custom_woocommerce_fee_fields() {
    $product_info = get_post_meta( get_the_ID(), 'telecurazao_product_no_options', true );
    $product_fees = (array) get_post_meta( get_the_ID(), 'telecurazao_custom_fees', true );
    foreach ($product_fees as $key => $value) {
        if (empty($value)) {
            unset($product_fees[$key]);
        }
    }

    /* CUSTOM PRODUCT DURATION */
    if ($product_info != 'on') { ?>
<div class="woocommerce-custom-single-input-wrapper">
    <label for="ads_duration">Commercial Duration: </label>
    <select name="ads_duration" id="ads_duration" class="form-control">
        <option value="15">15 Seconds</option>
        <option value="30" selected>30 Seconds</option>
        <option value="45">45 Seconds</option>
        <option value="60">1 Minute</option>
    </select>
</div>
<?php }

    /* CUSTOM PRODUCT START DATE */
    $dt = new DateTime(); ?>
<div class="woocommerce-custom-single-input-wrapper">
    <label for="ads_start_date">Commercial Start Date: </label>
    <div class="input-group date">
        <input id="ads_start_date" type="text" name="ads_start_date" class="form-control" value="<?php echo $dt->format('m/d/Y'); ?>">
    </div>
</div>
<?php /* CUSTOM FEE FIELDS */ ?>
<?php if (!empty($product_fees)) { ?>
<div class="woocommerce-custom-single-input-wrapper">
    <label>Add Additional Services: </label>

    <?php $i = 0; foreach ($product_fees as $product_fees_item) { ?>
    <div class="input-group-checkbox">
        <input id="fee_item_<?php echo $i; ?>" type="checkbox" name="fee_item_<?php echo $i; ?>" class="form-control" value="1"><label for="fee_item_<?php echo $i; ?>">
        <?php echo $product_fees_item['telecurazao_fee_label'] . ' - $ ' . $product_fees_item['telecurazao_fee_price'] ?></label>
    </div>
    <?php $i++; } ?>
</div>
<?php }
}

/* --------------------------------------------------------------
ADD CUSTOM DATA TO ITEM CART
-------------------------------------------------------------- */

add_filter( 'woocommerce_add_cart_item_data', 'add_cart_item_custom_data_vase', 10, 2 );
function add_cart_item_custom_data_vase( $cart_item_meta, $product_id ) {
    global $woocommerce;
    $cart_item_meta['ads_duration'] = $_POST['ads_duration'];
    $cart_item_meta['ads_start_date'] = $_POST['ads_start_date'];
    $product_fees = (array) get_post_meta( $product_id, 'telecurazao_custom_fees', true );
    foreach ($product_fees as $key => $value) {
        if (empty($value)) {
            unset($product_fees[$key]);
        }
    }

    foreach ($_POST as $key => $value) {
        if (strpos($key, 'fee_item_') !== false) {
            $fee_id = substr($key, -1);
            $cart_item_meta['fee_item_' . $fee_id] = $product_fees[$fee_id];
        }

    }
    return $cart_item_meta;
}

/* --------------------------------------------------------------
ADD CUSTOM DATA TO ITEM CART
-------------------------------------------------------------- */

add_filter( 'woocommerce_get_item_data', 'wc_add_info_to_cart', 10, 2 );
function wc_add_info_to_cart( $cart_data, $cart_item )
{
    $custom_items = array();

    if( !empty( $cart_data ) )
        $custom_items = $cart_data;

    if( isset( $cart_item["ads_duration"] ) ) {
        $custom_items[] = array(
            'name' => __( 'Duration', 'telecurazao' ),
            'value' => $cart_item["ads_duration"],
            'display' => $cart_item["ads_duration"] . ' ' . __('Seconds', 'telecurazao')
        );
    }
    if( isset( $cart_item["ads_start_date"] ) ) {
        $custom_items[] = array(
            'name' => __( 'Start Date', 'telecurazao' ),
            'value' => $cart_item["ads_start_date"],
            'display' => $cart_item["ads_start_date"]
        );
    }

    foreach ($cart_item as $key => $value) {
        if (strpos($key, 'fee_item_') !== false) {
            $fee_id = substr($key, -1);
            if( isset( $cart_item["fee_item_" . $fee_id] ) ) {
                $custom_items[] = array(
                    'name' => '+ ' . $cart_item["fee_item_" . $fee_id]["telecurazao_fee_label"],
                    'value' => floatval($cart_item["fee_item_" . $fee_id]["telecurazao_fee_price"]),
                    'display' => '$ ' . $cart_item["fee_item_" . $fee_id]["telecurazao_fee_price"]
                );
            }
        }
    }
    return $custom_items;
}

/* --------------------------------------------------------------
CALCULATE PRICE BY CART ITEM
-------------------------------------------------------------- */

add_filter( 'woocommerce_before_calculate_totals', 'custom_cart_items_prices', 10, 1 );
function custom_cart_items_prices( $cart ) {

    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
        return;

    // Loop Through cart items
    $acc_fees = 0;
    foreach ( $cart->get_cart() as $cart_item ) {

        $price = $cart_item['data']->get_price();
        $quantity = $cart_item['quantity'];
        if (isset($cart_item['ads_duration'])) {
            switch ($cart_item['ads_duration']) {
                case '15':
                    $duration = 0.5;
                    break;
                case '30':
                    $duration = 1;
                    break;
                case '45':
                    $duration = 1.5;
                    break;
                case '60':
                    $duration = 2;
                    break;
            }
        } else {
            $duration = 1;
        }

        foreach ($cart_item as $key => $value) {
            if (strpos($key, 'fee_item_') !== false) {
                $fee_id = substr($key, -1);
                if( isset( $cart_item["fee_item_" . $fee_id] ) ) {
                    $acc_fees = floatval($cart_item["fee_item_" . $fee_id]["telecurazao_fee_price"]);
                }
            }
        }

        // GET THE NEW PRICE (code to be replace by yours)
        $new_price = ($price * $duration) + $acc_fees;

        // Updated cart item price
        $cart_item['data']->set_price( $new_price );
    }
}

/* --------------------------------------------------------------
ADD CLASSES FOR WOOCOMMERCE CHECKOUT FIELDS
-------------------------------------------------------------- */

add_filter('woocommerce_checkout_fields', 'addBootstrapToCheckoutFields' );
function addBootstrapToCheckoutFields($fields) {
    foreach ($fields as &$fieldset) {
        foreach ($fieldset as &$field) {
            // if you want to add the form-group class around the label and the input
            $field['class'][] = 'form-group';

            // add form-control to the actual input
            $field['input_class'][] = 'form-control';
        }
    }
    return $fields;
}

/* --------------------------------------------------------------
ADD CUSTOM FIELDS FOR CHECKOUT
-------------------------------------------------------------- */

/** Add the field to the checkout **/
add_action( 'woocommerce_after_order_notes', 'my_custom_checkout_field' );

function my_custom_checkout_field( $checkout ) {
    global  $woocommerce;
    woocommerce_form_field( 'tax_id', array(
        'type'          => 'text',
        'class'         => array('tax_id_class form-row-wide'),
        'input_class'   => array('form-control'),
        'label'         => __('Tax ID | KvK'),
        'placeholder'   => __('Enter your Tax ID or KvK'),
    ), $checkout->get_value( 'tax_id' ));

?>
<div class="sales_agent_wrapper">
    <div class="sales_agent_item">
        <label for="sales_agent">
            <?php _e('Sales Agent', 'telecurazao'); ?>
            <?php _e('(Optional)', 'telecurazao'); ?></label>
        <select name="sales_agent" id="sales_agent" class="form-control">
            <?php $args = array('post_type' => 'sales-agents', 'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'ASC' ); ?>
            <?php $sales_agents = new WP_Query($args); $i = 1; ?>
            <?php if ($sales_agents->have_posts()) : ?>
            <?php while ($sales_agents->have_posts()) : $sales_agents->the_post(); ?>
            <?php if ($i == 1) { $class = 'selected'; } else { $class = ''; } ?>
            <option value="<?php echo get_the_ID(); ?>" <?php echo $class; ?>>
                <?php the_title(); ?>
            </option>
            <?php $i++; endwhile; ?>
            <?php endif; ?>
            <?php wp_reset_query(); ?>
        </select>
    </div>
</div>
<?php

    echo '<div class="advertisement_selector_wrapper">';

    echo '<label class="section-checkout-title">' . __('Choose your advertisement settings'). '</label>';
?>

<div class="advertisement_settings_wrapper">
    <div class="advertisement_item">
        <input type="radio" id="ads_file" name="advertisement_type" id="advertisement_type" value="ads_file" checked="checked">
        <label for="ads_file">
            <?php _e('Commercial on File'); ?></label>
    </div>
    <div class="advertisement_item">
        <input id="ads_upload" type="radio" name="advertisement_type" id="advertisement_type" value="ads_upload">
        <label for="ads_upload">
            <?php _e('Upload Commercial'); ?></label>
    </div>
    <div class="advertisement_item">
        <input type="radio" id="ads_production" name="advertisement_type" id="advertisement_type" value="ads_production">
        <label for="ads_production">
            <?php echo 'Request Commercial Production (Additional ' . get_woocommerce_currency_symbol() . ' 250 to your order)'; ?></label>
    </div>
</div>

<?php

    echo '</div>';

    echo '<div id="checkout_url_file_wrapper" class="checkout-hidden">';

    woocommerce_form_field( 'checkout_url_file', array(
        'type'          => 'text',
        'class'         => array('checkout_url_file_class form-row-wide'),
        'label'         => __('Upload your Advertisement'),
        'placeholder'   => __(''),
        'required'      => false,
        'label_class'   => array('checkout_url_file_label'),
    ), $checkout->get_value( 'checkout_url_file' ));

?>

<div class="checkout_url_file_uploader">
    <div class="checkout_url_file_handler">
        <input type="file" id="sortpicture" name="upload">
        <i class="save-support checkout-support fa fa-cloud-upload"></i>
    </div>
    <div class="checkout_url_file_handler_progress">
        <div class="progress">
            <div id="checkout_url_progress_bar" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
    <div class="checkout_url_file_handler_success video_upload_url_file_handler_success">
        <?php _e('Upload your advertisement here', 'telecurazao'); ?>
    </div>
</div>
<?php

    echo '</div>';

    echo '<div id="commercial_request_production" class="checkout-hidden">';

    echo '<label class="section-checkout-title">' . __('Request commercial Production'). '</label>';

    woocommerce_form_field( 'commercial_duration', array(
        'type'          => 'number',
        'class'         => array('commercial_duration form-row-wide'),
        'input_class'   => array('form-control'),
        'label'         => __('Duration of Commercial'),
        'placeholder'   => __('Quantity in seconds'),
        'custom_attributes' => array('min' => 0),
        'required'      => false,
    ), $checkout->get_value( 'commercial_duration' ));

    woocommerce_form_field( 'commercial_fill_in', array(
        'type'          => 'textarea',
        'class'         => array('commercial_duration form-row-wide'),
        'input_class'   => array('form-control'),
        'label'         => __('Fill-In'),
        'placeholder'   => __('Voice over text'),
        'required'      => false,
    ), $checkout->get_value( 'commercial_fill_in' ));

    woocommerce_form_field( 'commercial_describe', array(
        'type'          => 'textarea',
        'class'         => array('commercial_duration form-row-wide'),
        'input_class'   => array('form-control'),
        'label'         => __('Describe'),
        'placeholder'   => __('Commercial Objective / Target Group / Slogan'),
        'required'      => false,
    ), $checkout->get_value( 'commercial_describe' ));

    woocommerce_form_field( 'audio_url_file', array(
        'type'          => 'text',
        'class'         => array('checkout_url_file_class form-row-wide'),
        'label'         => __('Upload Audio/Jingle:'),
        'placeholder'   => __(''),
        'required'      => false,
        'label_class'   => array('checkout_url_file_label'),
    ), $checkout->get_value( 'audio_url_file' ));

?>
<div class="checkout_url_file_uploader">
    <div class="checkout_url_file_handler">
        <input type="file" id="audio_sortpicture" name="upload">
        <i class="save-support audio-support fa fa-cloud-upload"></i>
    </div>
    <div class="checkout_url_file_handler_progress audio_url_file_handler_progress">
        <div class="progress">
            <div id="checkout_url_progress_bar audio_url_progress_bar" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
    <div class="checkout_url_file_handler_success audio_url_file_handler_success">
        <?php _e('Upload Audio / Jingle here', 'telecurazao'); ?>
    </div>
</div>
<?php

    woocommerce_form_field( 'raw_url_file', array(
        'type'          => 'text',
        'class'         => array('checkout_url_file_class form-row-wide'),
        'label'         => __('Upload Raw Video:'),
        'placeholder'   => __(''),
        'required'      => false,
        'label_class'   => array('checkout_url_file_label'),
    ), $checkout->get_value( 'raw_url_file' ));

?>
<div class="checkout_url_file_uploader">
    <div class="checkout_url_file_handler">
        <input type="file" id="raw_sortpicture" name="upload">
        <i class="save-support raw-support fa fa-cloud-upload"></i>
    </div>
    <div class="checkout_url_file_handler_progress raw_url_file_handler_progress">
        <div class="progress">
            <div id="checkout_url_progress_bar raw_url_progress_bar" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
    <div class="checkout_url_file_handler_success raw_url_file_handler_success">
        <?php _e('Upload Raw Video here', 'telecurazao'); ?>
    </div>
</div>
<?php

    woocommerce_form_field( 'logo_url_file', array(
        'type'          => 'text',
        'class'         => array('checkout_url_file_class form-row-wide'),
        'label'         => __('Upload Company Image / Logo:'),
        'placeholder'   => __(''),
        'required'      => false,
        'label_class'   => array('checkout_url_file_label'),
    ), $checkout->get_value( 'logo_url_file' ));

?>
<div class="checkout_url_file_uploader">
    <div class="checkout_url_file_handler">
        <input type="file" id="logo_sortpicture" name="upload">
        <i class="save-support logo-support fa fa-cloud-upload"></i>
    </div>
    <div class="checkout_url_file_handler_progress logo_url_file_handler_progress">
        <div class="progress">
            <div id="checkout_url_progress_bar logo_url_progress_bar" class="progress-bar bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
    <div class="checkout_url_file_handler_success logo_url_file_handler_success">
        <?php _e('Upload Company Image / Logo here', 'telecurazao'); ?>
    </div>
</div>
<?php
    echo '</div>';
}


/* --------------------------------------------------------------
Update the order meta with field value
-------------------------------------------------------------- */

add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );

function my_custom_checkout_field_update_order_meta( $order_id ) {
    if ( ! empty( $_POST['checkout_url_file'] ) ) {
        update_post_meta( $order_id, 'checkout_url_file', sanitize_text_field( $_POST['checkout_url_file'] ) );
    }
    if ( ! empty( $_POST['tax_id'] ) ) {
        update_post_meta( $order_id, 'tax_id', sanitize_text_field( $_POST['tax_id'] ) );
    }
    if ( ! empty( $_POST['advertisement_type'] ) ) {
        update_post_meta( $order_id, 'advertisement_type', sanitize_text_field( $_POST['advertisement_type'] ) );
    }
    if ( ! empty( $_POST['commercial_duration'] ) ) {
        update_post_meta( $order_id, 'commercial_duration', sanitize_text_field( $_POST['commercial_duration'] ) );
    }
    if ( ! empty( $_POST['commercial_fill_in'] ) ) {
        update_post_meta( $order_id, 'commercial_fill_in', sanitize_text_field( $_POST['commercial_fill_in'] ) );
    }
    if ( ! empty( $_POST['commercial_describe'] ) ) {
        update_post_meta( $order_id, 'commercial_describe', sanitize_text_field( $_POST['commercial_describe'] ) );
    }
    if ( ! empty( $_POST['audio_url_file'] ) ) {
        update_post_meta( $order_id, 'audio_url_file', sanitize_text_field( $_POST['audio_url_file'] ) );
    }
    if ( ! empty( $_POST['raw_url_file'] ) ) {
        update_post_meta( $order_id, 'raw_url_file', sanitize_text_field( $_POST['raw_url_file'] ) );
    }
    if ( ! empty( $_POST['logo_url_file'] ) ) {
        update_post_meta( $order_id, 'logo_url_file', sanitize_text_field( $_POST['logo_url_file'] ) );
    }
    if ( ! empty( $_POST['sales_agent'] ) ) {
        update_post_meta( $order_id, 'sales_agent', sanitize_text_field( $_POST['sales_agent'] ) );
    }
}

/* --------------------------------------------------------------
Display field value on the order edit page
-------------------------------------------------------------- */

add_action( 'woocommerce_admin_order_data_after_shipping_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){

    $tax_id_meta = get_post_meta( $order->id, 'tax_id', true );
    echo '<p class="order_note"><strong>'.__('Tax Id | KvK').':</strong> </p><p>' . $tax_id_meta . '</p>';
    $sales_agent_meta = get_post_meta( $order->id, 'sales_agent', true );
    $sales_agent_post = get_post($sales_agent_meta);
    echo '<p class="order_note"><strong>'.__('Sales Agent').':</strong> </p><p>' . $sales_agent_post->post_title . '</p>';
    $type_ads = get_post_meta( $order->id, 'advertisement_type', true );
    if ($type_ads == 'ads_upload') {
        echo '<div class="checkout_url_file_order_wrapper">';
        $checkout_url_meta = get_post_meta( $order->id, 'checkout_url_file', true );
        echo '<p class="order_note"><strong>'.__('Advertisement').':</strong> </p><p><a href="'. esc_url($checkout_url_meta) .'" title="Download Ads" download>' . $checkout_url_meta . '</a></p>';
        echo '</div>';
    }
    if ($type_ads == 'ads_file') {
        echo '<div class="checkout_url_file_order_wrapper">';
        echo '<p>Type of Ads:</p>' . '<h2>Commercial On File</h2>';
        echo '</div>';
    }
    if ($type_ads == 'ads_production') {
        echo '<div class="checkout_url_file_order_wrapper">';
        $commercial_duration_meta = get_post_meta( $order->id, 'commercial_duration', true );
        echo '<p class="order_note"><strong>'.__('Ads Duration').':</strong> </p><p>' . $commercial_duration_meta . ' Seconds</p>';
        $commercial_fill_in_meta = get_post_meta( $order->id, 'commercial_fill_in', true );
        echo '<p class="order_note"><strong>'.__('Ads Fill-In').':</strong> </p><p>' . $commercial_fill_in_meta . '</p>';
        $commercial_describe_meta = get_post_meta( $order->id, 'commercial_describe', true );
        echo '<p class="order_note"><strong>'.__('Ads Description:').':</strong> </p><p>' . $commercial_describe_meta . '</p>';
        $audio_url_file_meta = get_post_meta( $order->id, 'audio_url_file', true );
        echo '<p class="order_note"><strong>'.__('Audio / Jingle').':</strong> </p><p><a href="'. esc_url($audio_url_file_meta) .'" title="Download Jingle" download>' . $audio_url_file_meta . '</a></p>';
        $raw_url_file_meta = get_post_meta( $order->id, 'raw_url_file', true );
        echo '<p class="order_note"><strong>'.__('Raw Video').':</strong> </p><p><a href="'. esc_url($raw_url_file_meta) .'" title="Download Raw Video" download>' . $raw_url_file_meta . '</a></p>';
        $logo_url_file_meta = get_post_meta( $order->id, 'logo_url_file', true );
        echo '<p class="order_note"><strong>'.__('Company Image / Logo').':</strong> </p><p><a href="'. esc_url($logo_url_file_meta) .'" title="Download Company Image / Logo" download>' . $logo_url_file_meta . '</a></p>';
        echo '</div>';
    }
}

/* --------------------------------------------------------------
update item cart key values
-------------------------------------------------------------- */

add_action( 'woocommerce_checkout_create_order_line_item', 'add_booking_order_line_item', 20, 4 );
function add_booking_order_line_item( $item, $cart_item_key, $values, $order ) {
    switch ($values['ads_duration']) {
        case 15:
            $duration = '15 Seconds';
            break;
        case 30:
            $duration = '30 Seconds';
            break;
        case 45:
            $duration = '45 Seconds';
            break;
        case 60:
            $duration = '1 Minute';
            break;
    }
    // Get cart item custom data and update order item meta
    if( isset( $values['ads_duration'] ) ){
        if( ! empty( $values['ads_duration'] ) )
            $item->update_meta_data( 'Duration', $duration );
    }
    if( isset( $values['ads_start_date'] ) ){
        if( ! empty( $values['ads_start_date'] ) )
            $item->update_meta_data( 'Commercial Start Date', $values['ads_start_date'] );
    }
    foreach ($values as $key => $value) {
        if (strpos($key, 'fee_item_') !== false) {
            $fee_id = substr($key, -1);
            if( isset( $values["fee_item_" . $fee_id] ) ) {
                if( ! empty( $values["fee_item_" . $fee_id] ) )
                    $item->update_meta_data( $values["fee_item_" . $fee_id]["telecurazao_fee_label"], $values["fee_item_" . $fee_id]["telecurazao_fee_price"] );
            }
        }
    }
}

/* --------------------------------------------------------------
ADD CUSTOM FEES
-------------------------------------------------------------- */

add_action( 'woocommerce_cart_calculate_fees', 'woo_add_cart_fee' );
function woo_add_cart_fee( $cart ){
    if ( ! $_POST || ( is_admin() && ! is_ajax() ) ) {
        return;
    }

    if ( isset( $_POST['post_data'] ) ) {
        parse_str( $_POST['post_data'], $post_data );
    } else {
        $post_data = $_POST;
    }

    if (isset($post_data['advertisement_type'])) {

        if ($post_data['advertisement_type'] == 'ads_production'){
            $extracost = 250;
            WC()->cart->add_fee( 'Request commercial Production Fee:', $extracost );
        } else {
            $extracost = 0;
            WC()->cart->add_fee( 'Request commercial Production Fee:', $extracost );
        }

    }

}


/* --------------------------------------------------------------
ADD CUSTOM EXTRA FIELDS
-------------------------------------------------------------- */
function wooc_extra_register_fields() {?>
<p class="form-row form-row-first">
    <label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?><span class="required">*</span></label>
    <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
</p>
<p class="form-row form-row-last">
    <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?><span class="required">*</span></label>
    <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
</p>
<div class="clear"></div>
<p class="form-row form-row-wide">
    <label for="reg_billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?></label>
    <input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php if ( ! empty( $_POST['billing_phone'] ) ) esc_attr_e( $_POST['billing_phone'] ); ?>" />
</p>
<p class="form-row form-row-wide">
    <label for="reg_billing_company"><?php _e( 'Business', 'woocommerce' ); ?></label>
    <input type="text" class="input-text" name="billing_company" id="reg_billing_company" value="<?php if ( ! empty( $_POST['billing_company'] ) ) esc_attr_e( $_POST['billing_company'] ); ?>" />
</p>

<?php
                                      }
add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );

function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {
    if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
        $validation_errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required!', 'woocommerce' ) );
    }
    if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
        $validation_errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required!.', 'woocommerce' ) );
    }
    return $validation_errors;
}
add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );

function wooc_save_extra_register_fields( $customer_id ) {
    if ( isset( $_POST['billing_phone'] ) ) {
        // Phone input filed which is used in WooCommerce
        update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
    }
    if ( isset( $_POST['billing_company'] ) ) {
        // Phone input filed which is used in WooCommerce
        update_user_meta( $customer_id, 'billing_company', sanitize_text_field( $_POST['billing_company'] ) );
    }
    if ( isset( $_POST['billing_first_name'] ) ) {
        //First name field which is by default
        update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
        // First name field which is used in WooCommerce
        update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
    }
    if ( isset( $_POST['billing_last_name'] ) ) {
        // Last name field which is by default
        update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
        // Last name field which is used in WooCommerce
        update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
    }
}
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );

function new_contact_methods( $contactmethods ) {
    $contactmethods['billing_company'] = 'Billing Company';
    return $contactmethods;
}
add_filter( 'user_contactmethods', 'new_contact_methods', 10, 1 );


function new_modify_user_table( $column ) {
    $column['billing_company'] = 'Company';
    return $column;
}
add_filter( 'manage_users_columns', 'new_modify_user_table' );

function new_modify_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'billing_company' :
            return get_the_author_meta( 'billing_company', $user_id );
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row', 10, 3 );
