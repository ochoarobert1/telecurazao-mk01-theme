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

/* ADD CLASSES FOR WOOCOMMERCE CHECKOUT FIELDS */
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


/* ADD CUSTOM DATA TO ITEM CART */
add_filter( 'woocommerce_add_cart_item_data', 'add_cart_item_custom_data_vase', 10, 2 );
function add_cart_item_custom_data_vase( $cart_item_meta, $product_id ) {
    global $woocommerce;
    $cart_item_meta['ads_duration'] = $_POST['ads_duration'];
    $cart_item_meta['ads_start_date'] = $_POST['ads_start_date'];
    return $cart_item_meta;
}

/* ADD CUSTOM DATA TO ITEM CART */
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

    return $custom_items;
}

/* CALCULATE PRICE BY CART ITEM */
add_filter( 'woocommerce_before_calculate_totals', 'custom_cart_items_prices', 10, 1 );
function custom_cart_items_prices( $cart ) {

    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
        return;

    // Loop Through cart items
    foreach ( $cart->get_cart() as $cart_item ) {
        $price = $cart_item['data']->get_price();
        $quantity = $cart_item['quantity'];
        if (isset($cart_item['ads_duration'])) {
            switch ($cart_item['ads_duration']) {
                case 15:
                    $duration = 0.5;
                    break;
                case 30:
                    $duration = 1;
                    break;
                case 45:
                    $duration = 1.5;
                    break;
                case 100:
                    $duration = 2;
                    break;
            }
        } else {
            $duration = 1;
        }

        // GET THE NEW PRICE (code to be replace by yours)
        $new_price = ($price * $quantity) * $duration;

        // Updated cart item price
        $cart_item['data']->set_price( $new_price );
    }
}


/**
 * Add the field to the checkout
 */
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
            <option value="House Account" selected>
                <?php _e('House Account', 'telecurazao'); ?>
            </option>
            <option value="Deyanira van der Linde">
                <?php _e('Deyanira van der Linde', 'telecurazao'); ?>
            </option>
            <option value="Aimee St. Jago">
                <?php _e('Aimee St. Jago', 'telecurazao'); ?>
            </option>
            <option value="Sharleen Walle">
                <?php _e('Sharleen Walle', 'telecurazao'); ?>
            </option>
            <option value="Carla Morales">
                <?php _e('Carla Morales', 'telecurazao'); ?>
            </option>
            <option value="Freelance agent">
                <?php _e('Freelance agent', 'telecurazao'); ?>
            </option>
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


/**
 * Update the order meta with field value
 */
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

/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_shipping_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){

    $tax_id_meta = get_post_meta( $order->id, 'tax_id', true );
    echo '<p class="order_note"><strong>'.__('Tax Id | KvK').':</strong> </p><p>' . $tax_id_meta . '</p>';
    $sales_agent_meta = get_post_meta( $order->id, 'sales_agent', true );
    echo '<p class="order_note"><strong>'.__('Sales Agent').':</strong> </p><p>' . $sales_agent_meta . '</p>';
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

add_action( 'woocommerce_checkout_create_order_line_item', 'add_booking_order_line_item', 20, 4 );
function add_booking_order_line_item( $item, $cart_item_key, $values, $order ) {
    switch ($cart_item['ads_duration']) {
        case 15:
            $duration = '15 Seconds';
            break;
        case 30:
            $duration = '30 Seconds';
            break;
        case 45:
            $duration = '45 Seconds';
            break;
        case 100:
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
}

add_action( 'woocommerce_cart_calculate_fees', 'woo_add_cart_fee' );
function woo_add_cart_fee( $cart ){
    if ( ! $_POST || ( is_admin() && ! is_ajax() ) ) {
        return;
    }

    if ( isset( $_POST['post_data'] ) ) {
        parse_str( $_POST['post_data'], $post_data );
    } else {
        $post_data = $_POST; // fallback for final checkout (non-ajax)
    }

    if (isset($post_data['advertisement_type'])) {

        if ($post_data['advertisement_type'] == 'ads_production'){
            $extracost = 250; // not sure why you used intval($_POST['state']) ?
            WC()->cart->add_fee( 'Request commercial Production Fee:', $extracost );
        } else {
            $extracost = 0; // not sure why you used intval($_POST['state']) ?
            WC()->cart->add_fee( 'Request commercial Production Fee:', $extracost );
        }
    }

}


