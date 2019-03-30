<?
add_action('woocommerce_email_before_order_table', 'bdev_add_coupon_code_to_order_email', 20, 4);
function bdev_add_coupon_code_to_order_email($order, $sent_to_admin, $plain_text, $email) {
    $product_ids = '';
    foreach ($order->get_items() as $item) {
        $product_ids .= $item->get_product_id() . ',';
    }

    if (($email->id == 'customer_completed_order') && (strpos($product_ids, '2671') !== false)) {

        $coupon_code = wp_rand();
        $amount = '100';
        $discount_type = 'fixed_cart'; // Type: fixed_cart, percent, fixed_product, percent_product
        $coupon = array(
        'post_title' => $coupon_code,
        'post_content' => '',
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type' => 'shop_coupon');

        $new_coupon_id = wp_insert_post($coupon);
        update_post_meta($new_coupon_id, 'discount_type', $discount_type);
        update_post_meta($new_coupon_id, 'coupon_amount', $amount);
        update_post_meta($new_coupon_id, 'coupon_description', 'coupons for discount 100฿ after order Sample Set');
        update_post_meta($new_coupon_id, 'individual_use', 'no');
        //update_post_meta($new_coupon_id, 'product_ids', $product_ids);
        update_post_meta($new_coupon_id, 'exclude_product_ids', '');
        update_post_meta($new_coupon_id, 'usage_limit', '1');
        update_post_meta($new_coupon_id, 'usage_limit_per_user', '1');
        update_post_meta($new_coupon_id, 'expiry_date', '');
        update_post_meta($new_coupon_id, 'apply_before_tax', 'yes');
        update_post_meta($new_coupon_id, 'free_shipping', 'no');
        unset($product_ids);
        echo '<h2 class="discount-coupon-title">THIS IS YOUR NEXT DISCOUNT</h2><p class="discount-coupon-text">When you\'re ready, welcome back to a 100฿ discount!<br/> This is your discount code: <code><strong>' . $coupon_code . '</strong></code></p>';
    }
?>
<style>
    .discount-coupon-title { color: red; }
    .discount-coupon-text { color: black; }
</style>
<?php
}