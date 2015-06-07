<?php
/**
*
* @package         EDD\PerProductButton\includes
* @author          WP Human
* @copyright       Copyright (c) WP Human
*
*/


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;


/**
* The public-facing functionality of the plugin.
*
* @since       1.0.0
*/

class EDD_Per_Product_Button_Public {

	/**
	* Change the button text, style and color
	*
	* @param 	array 	$args 	Default arguments for display
	* @return 	string 			Sanitized user input

	* @since 1.0.0
	*/
	public function purchase_link_args( $args ) {

		$post_id = $args['download_id'];
		$text = get_post_meta( $post_id, '_edd_per_product_button_text', true );
		$style = get_post_meta( $post_id, '_edd_per_product_button_style', true );
		$color = get_post_meta( $post_id, '_edd_per_product_button_color', true );

		if ( !empty( $text ) ) {
			$args['text'] = $text;
		}

		if ( !empty( $style ) ) {
			$args['style'] = $style;
		}

		if ( !empty( $color ) ) {
			$args['color'] = $color;
		}

		return $args;
	}
}
