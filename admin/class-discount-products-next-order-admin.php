<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://walnutztudio.com
 * @since      1.0.0
 *
 * @package    Discount_Products_Next_Order
 * @subpackage Discount_Products_Next_Order/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Discount_Products_Next_Order
 * @subpackage Discount_Products_Next_Order/admin
 * @author     WalnutZtudio <walnutztudio@gmail.com>
 */
class Discount_Products_Next_Order_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Discount_Products_Next_Order_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Discount_Products_Next_Order_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/discount-products-next-order-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Discount_Products_Next_Order_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Discount_Products_Next_Order_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/discount-products-next-order-admin.js', array( 'jquery' ), $this->version, false );

	}
}

/**
* Check if WooCommerce is active
**/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	add_action('woocommerce_email_before_order_table', 'wz_add_coupon_for_next_order', 20, 4);
	
	function wz_add_coupon_for_next_order($order, $sent_to_admin, $plain_text, $email) {
		$product_ids = '';
		foreach ($order->get_items() as $item) {
			$product_ids .= $item->get_product_id() . ',';
		}
		if (($email->id == 'customer_completed_order') && (strpos($product_ids, '72') !== false)) {
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
			echo '<br><hr><br><h2 class="discount-coupon-title">GET YOUR DISCOUNT FOR THE NEXT ORDER!</h2>
			<p class="discount-coupon-text">When you\'re ready, welcome back to a 100 ฿ discount!</p>
			<h2 class="discount-coupon-code"><strong>' . $coupon_code . '</h2><hr><br>';
		}
	?>
	<style>
		.discount-coupon-title { color: red; text-align: center;}
		.discount-coupon-text { color: black; text-align: center;}
		.discount-coupon-code {color:#676767; text-align: center;}
	</style>
	<?php
	}
}
