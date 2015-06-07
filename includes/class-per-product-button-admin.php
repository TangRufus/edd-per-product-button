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

class EDD_Per_Product_Button_Admin {

	/**
	* Per Product Button Fields
	*
	* Adds fields do the EDD Downloads meta box for specifying the "Per Product Button"
	*
	* @since 1.0.0
	* @param integer $post_id Download (Post) ID
	*/
	public function meta_box_fields( $post_id ) {

		$edd_per_product_button_text = get_post_meta( $post_id, '_edd_per_product_button_text', true );
		$edd_per_product_button_style = get_post_meta( $post_id, '_edd_per_product_button_style', true );
		$edd_per_product_button_color = get_post_meta( $post_id, '_edd_per_product_button_color', true );

		$colors = edd_get_button_colors();
		?>

		<p><strong><?php _e( 'Per Product Button:', 'edd-external-product' ); ?></strong></p>

		<table class="widefat" width="100%" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>Add to Cart Text</th>
					<th>Style</th>
					<th>Color</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<input type="text" name="_edd_per_product_button_text" id="edd_per_product_button_text" value="<?php echo esc_attr( $edd_per_product_button_text ); ?>" placeholder="Add to Cart"/>
					</td>
					<td>
						<select id="edd_per_product_button_style" name="_edd_per_product_button_style">
							<option value=""><?php _e( 'Use default style', 'edd' ); ?></option>
							<option value="button" <?php selected( $edd_per_product_button_style, "button" ) ?> >button</option>
							<option value="text link"  <?php selected( $edd_per_product_button_style, "text link" ) ?> >text link</option>
						</select>
					</td>
					<td>
						<?php
						if( $colors ) {
							?>
							<select id="edd_per_product_button_color" name="_edd_per_product_button_color">
								<option value="">
									<?php _e('Use default button color', 'edd'); ?>
								</option>
								<?php
								foreach ( $colors as $key => $color ) {
									$color_val = str_replace( ' ', '_', $key );
									echo '<option value="' . $color_val . '"' . selected( $edd_per_product_button_color, $color_val ) . '>' . $color['label'] . '</option>';
								}
								?>
							</select>
							<?php } ?>
						</td>
					</tr>
				</tbody>
			</table>

			<?php _e( 'The add to cart text for this pictacular product', 'edd-external-product' ); ?>

			<script type="text/javascript">
			function handleSelectStyleChange() {
				if ( jQuery('#edd_per_product_button_style').val() === 'button') {
					jQuery('#edd_per_product_button_color').removeAttr('disabled');
				} else {
					jQuery('#edd_per_product_button_color').attr('disabled','disabled');
				};
			};
			jQuery(document).ready(function () {
				handleSelectStyleChange();
				jQuery('#edd_per_product_button_style').change( handleSelectStyleChange );
			});
			</script>
			<?php
		}

		/**
		* Add the EDD Per Product Button fields to the list of saved product fields
		*
		* @since  1.0.0
		*
		* @param  array $fields The default product fields list
		* @return array         The updated product fields list
		*/
		public function metabox_fields_save( $fields ) {

			// Add our fields
			$fields[] = '_edd_per_product_button_text';
			$fields[] = '_edd_per_product_button_style';
			$fields[] = '_edd_per_product_button_color';

			// Return the fields array
			return $fields;
		}

		/**
		* Sanitize button_text
		*
		* @param  string $input	User input
		* @return string 		Sanitized user input

		* @since 1.0.0
		*/
		public function sanitize_button_text( $input ) {

			return sanitize_text_field( $input );

		}

		/**
		* Sanitize button style
		*
		* @param  string $input	User input
		* @return string 		Sanitized user input

		* @since 1.0.0
		*/
		public function sanitize_button_style( $input ) {

			$accepted_styles = array( 'text link', 'button' );

			if ( ! in_array( $input, $accepted_styles ) ) {
				$input = null;
			}

			return $input;

		}

		/**
		* Sanitize button color
		*
		* @param  string $input	User input
		* @return string 		Sanitized user input

		* @since 1.0.0
		*/
		public function sanitize_button_color( $input ) {

			$colors = edd_get_button_colors();

			foreach ( $colors as $key => $color ) {
				$accepted_colors[] = str_replace( ' ', '_', $key );
			}

			if ( ! in_array( $input, $accepted_colors ) ) {
				$input = null;
			}

			return $input;

		}
	}
