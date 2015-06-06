<?php
/**
 * Plugin Name:     Per Product Button
 * Plugin URI:      https://www.wphuman.com
 * Description:     @todo
 * Version:         1.0.0
 * Author:          WP Human
 * Author URI:      https://www.wphuman.com
 * Text Domain:     edd-per-product-button
 *
 * @package         EDD\PluginName
 * @author          WP Human
 * @copyright       Copyright (c) WP Human
 *
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'EDD_Per_Product_Button' ) ) {

	/**
	 * Main EDD_Per_Product_Button class
	 *
	 * @since       1.0.0
	 */
	class EDD_Per_Product_Button {

		/**
		 * @var         EDD_Per_Product_Button $instance The one true EDD_Per_Product_Button
		 * @since       1.0.0
		 */
		private static $instance;


		/**
		 * Get active instance
		 *
		 * @access      public
		 * @since       1.0.0
		 * @return      object self::$instance The one true EDD_Per_Product_Button
		 */
		public static function instance() {
			if( !self::$instance ) {
				self::$instance = new EDD_Per_Product_Button();
				self::$instance->setup_constants();
				self::$instance->includes();
				self::$instance->load_textdomain();
				self::$instance->hooks();
			}

			return self::$instance;
		}


		/**
		 * Setup plugin constants
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function setup_constants() {
			// Plugin version
			define( 'EDD_PER_PRODUCT_BUTTON_VER', '1.0.0' );

			// Plugin path
			define( 'EDD_PER_PRODUCT_BUTTON_DIR', plugin_dir_path( __FILE__ ) );

			// Plugin URL
			define( 'EDD_PER_PRODUCT_BUTTON_URL', plugin_dir_url( __FILE__ ) );
		}


		/**
		 * Include necessary files
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function includes() {
			// Include scripts

			/**
			 * @todo        The following files are not included in the boilerplate, but
			 *              the referenced locations are listed for the purpose of ensuring
			 *              path standardization in EDD extensions. Uncomment any that are
			 *              relevant to your extension, and remove the rest.
			 */
			// require_once EDD_PER_PRODUCT_BUTTON_DIR . 'includes/shortcodes.php';
			// require_once EDD_PER_PRODUCT_BUTTON_DIR . 'includes/widgets.php';
		}


		/**
		 * Run action and filter hooks
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 *
		 */
		private function hooks() {
			// Register settings
			add_filter( 'edd_settings_extensions', array( $this, 'settings' ), 1 );

			// Handle licensing
			// @todo        Replace the Per Product Button and Your Name with your data
			if( class_exists( 'EDD_License' ) ) {
				$license = new EDD_License( __FILE__, 'Per Product Button', EDD_PER_PRODUCT_BUTTON_VER, 'WP Human' );
			}
		}


		/**
		 * Internationalization
		 *
		 * @access      public
		 * @since       1.0.0
		 * @return      void
		 */
		public function load_textdomain() {
			// Set filter for language directory
			$lang_dir = EDD_PER_PRODUCT_BUTTON_DIR . '/languages/';
			$lang_dir = apply_filters( 'edd_per_product_button_languages_directory', $lang_dir );

			// Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale', get_locale(), 'edd-per-product-button' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'edd-per-product-button', $locale );

			// Setup paths to current locale file
			$mofile_local   = $lang_dir . $mofile;
			$mofile_global  = WP_LANG_DIR . '/edd-per-product-button/' . $mofile;

			if( file_exists( $mofile_global ) ) {
				// Look in global /wp-content/languages/edd-per-product-button/ folder
				load_textdomain( 'edd-per-product-button', $mofile_global );
			} elseif( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/edd-per-product-button/languages/ folder
				load_textdomain( 'edd-per-product-button', $mofile_local );
			} else {
				// Load the default language files
				load_plugin_textdomain( 'edd-per-product-button', false, $lang_dir );
			}
		}


		/**
		 * Add settings
		 *
		 * @access      public
		 * @since       1.0.0
		 * @param       array $settings The existing EDD settings array
		 * @return      array The modified EDD settings array
		 */
		public function settings( $settings ) {
			$new_settings = array(
				array(
					'id'    => 'edd_per_product_button_settings',
					'name'  => '<strong>' . __( 'Per Product Button Settings', 'edd-per-product-button' ) . '</strong>',
					'desc'  => __( 'Configure Per Product Button Settings', 'edd-per-product-button' ),
					'type'  => 'header',
				)
			);

			return array_merge( $settings, $new_settings );
		}
	}
} // End if class_exists check


/**
 * The main function responsible for returning the one true EDD_Per_Product_Button
 * instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \EDD_Per_Product_Button The one true EDD_Per_Product_Button
 *
 * @todo        Inclusion of the activation code below isn't mandatory, but
 *              can prevent any number of errors, including fatal errors, in
 *              situations where your extension is activated but EDD is not
 *              present.
 */
function EDD_Per_Product_Button_load() {
	if( ! class_exists( 'Easy_Digital_Downloads' ) ) {
		if( ! class_exists( 'EDD_Extension_Activation' ) ) {
			require_once 'includes/class.extension-activation.php';
		}

		$activation = new EDD_Extension_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
		$activation = $activation->run();
		return EDD_Per_Product_Button::instance();
	} else {
		return EDD_Per_Product_Button::instance();
	}
}
add_action( 'plugins_loaded', 'EDD_Per_Product_Button_load' );


/**
 * The activation hook is called outside of the singleton because WordPress doesn't
 * register the call from within the class, since we are preferring the plugins_loaded
 * hook for compatibility, we also can't reference a function inside the plugin class
 * for the activation function. If you need an activation function, put it here.
 *
 * @since       1.0.0
 * @return      void
 */
function edd_per_product_button_activation() {
	/* Activation functions here */
}
register_activation_hook( __FILE__, 'edd_per_product_button_activation' );
