<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
    return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

if ( $product->is_in_stock() ) : ?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>

   <?php $product_info = get_post_meta(get_the_ID(), 'telecurazao_product_no_options', true); ?>

   <?php if ($product_info != 'on') { ?>
    <div class="woocommerce-custom-single-input-wrapper">
        <label for="ads_duration">Commercial Duration: </label>
        <select name="ads_duration" id="ads_duration" class="form-control">
            <option value="15">15 Seconds</option>
            <option value="30">30 Seconds</option>
            <option value="45">45 Seconds</option>
            <option value="100">1 Minute</option>
        </select>
    </div>
    <?php } ?>

    <?php $dt = new DateTime(); ?>
    <div class="woocommerce-custom-single-input-wrapper">
        <label for="ads_start_date">Commercial Start Date: </label>
        <div class="input-group date">
            <input id="ads_start_date" type="text" name="ads_start_date" class="form-control"  value="<?php echo $dt->format('m/d/Y'); ?>">
        </div>
    </div>

    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

    <?php
    do_action( 'woocommerce_before_add_to_cart_quantity' );

    woocommerce_quantity_input( array(
        'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
        'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
        'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
    ) );

    do_action( 'woocommerce_after_add_to_cart_quantity' );
    ?>

    <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

    <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
