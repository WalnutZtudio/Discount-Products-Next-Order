<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://walnutztudio.com
 * @since      1.0.0
 *
 * @package    Discount_Products_Next_Order
 * @subpackage Discount_Products_Next_Order/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Discount_Products_Next_Order
 * @subpackage Discount_Products_Next_Order/includes
 * @author     WalnutZtudio <walnutztudio@gmail.com>
 */
class Discount_Products_Next_Order_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'discount-products-next-order',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
