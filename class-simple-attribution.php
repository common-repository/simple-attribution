<?php
/**
 * Plugin Name:     Simple Attribution
 * Plugin URI:      http://wordpress.org/plugins/simple-attribution/
 * Description:     Allows bloggers to easily add an attribution link to sourced blog posts.
 * Author:          Widgit Team
 * Author URI:      https://widgit.io
 * Version:         2.1.2
 * Text Domain:     simple-attribution
 * Domain Path:     languages
 *
 * @package         SimpleAttribution
 * @author          Daniel J Griffiths <dgriffiths@evertiro.com>
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Simple_Attribution' ) ) {


	/**
	 * Main Simple_Attribution class
	 *
	 * @access      public
	 * @since       1.0.0
	 */
	class Simple_Attribution {


		/**
		 * The one true Simple_Attribution
		 *
		 * @var         Simple_Attribution $instance The one true Simple_Attribution
		 * @since       1.1.0
		 */
		private static $instance;


		/**
		 * The settings object
		 *
		 * @var         object $settings The settings object
		 * @since       2.0.0
		 */
		public $settings;


		/**
		 * Get active instance
		 *
		 * @access      public
		 * @since       1.1.0
		 * @return      object self::$instance The one true Simple_Attribution
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Simple_Attribution ) ) {
				self::$instance = new Simple_Attribution();
				self::$instance->setup_constants();
				self::$instance->hooks();
				self::$instance->includes();
			}

			return self::$instance;
		}


		/**
		 * Throw error on object clone
		 *
		 * The whole idea of the singleton design pattern is that there is
		 * a single object. Therefore, we don't want the object to be cloned.
		 *
		 * @access      protected
		 * @since       1.0.0
		 * @return      void
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, esc_attr__( 'Cheatin&#8217; huh?', 'simple-attribution' ), '1.0.0' );
		}


		/**
		 * Disable unserializing of the class
		 *
		 * @access      protected
		 * @since       1.0.0
		 * @return      void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, esc_attr__( 'Cheatin&#8217; huh?', 'simple-attribution' ), '1.0.0' );
		}


		/**
		 * Setup plugin constants
		 *
		 * @access      private
		 * @since       1.1.0
		 * @return      void
		 */
		private function setup_constants() {
			// Plugin version.
			if ( ! defined( 'SIMPLE_ATTRIBUTION_VER' ) ) {
				define( 'SIMPLE_ATTRIBUTION_VER', '2.1.2' );
			}

			// Plugin path.
			if ( ! defined( 'SIMPLE_ATTRIBUTION_DIR' ) ) {
				define( 'SIMPLE_ATTRIBUTION_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin URL.
			if ( ! defined( 'SIMPLE_ATTRIBUTION_URL' ) ) {
				define( 'SIMPLE_ATTRIBUTION_URL', plugin_dir_url( __FILE__ ) );
			}
		}


		/**
		 * Run plugin base hooks
		 *
		 * @access      private
		 * @since       3.2.0
		 * @return      void
		 */
		private function hooks() {
			add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
		}


		/**
		 * Include necessary files
		 *
		 * @access      private
		 * @since       2.0.0
		 * @return      void
		 */
		private function includes() {
			global $simple_attribution_options;

			// Load settings handler if necessary.
			if ( ! class_exists( 'Simple_Settings' ) ) {
				require_once SIMPLE_ATTRIBUTION_DIR . 'vendor/widgitlabs/simple-settings/class-simple-settings.php';
			}

			require_once SIMPLE_ATTRIBUTION_DIR . 'includes/admin/settings/register-settings.php';

			self::$instance->settings   = new Simple_Settings( 'simple_attribution', 'settings' );
			$simple_attribution_options = self::$instance->settings->get_settings();

			require_once SIMPLE_ATTRIBUTION_DIR . 'includes/misc-functions.php';
			require_once SIMPLE_ATTRIBUTION_DIR . 'includes/scripts.php';
			require_once SIMPLE_ATTRIBUTION_DIR . 'includes/filters.php';

			if ( is_admin() ) {
				require_once SIMPLE_ATTRIBUTION_DIR . 'includes/admin/posts/meta-box.php';
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
			// Set filter for language directory.
			$lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
			$lang_dir = apply_filters( 'simple_attribution_lang_dir', $lang_dir );

			// Traditional WordPress plugin locale filter.
			$locale = apply_filters( 'plugin_locale', get_locale(), '' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'simple-attribution', $locale );

			// Setup paths to current locale file.
			$mofile_local  = $lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/simple-attribution/' . $mofile;
			$mofile_core   = WP_LANG_DIR . '/plugins/simple-attribution/' . $mofile;

			if ( file_exists( $mofile_global ) ) {
				// Look in global /wp-content/languages/simple-attribution/ folder.
				load_textdomain( 'simple-attribution', $mofile_global );
			} elseif ( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/simple-attribution/languages/ folder.
				load_textdomain( 'simple-attribution', $mofile_local );
			} elseif ( file_exists( $mofile_core ) ) {
				// Look in core /wp-content/languages/plugins/simple-attribution/ folder.
				load_textdomain( 'simple-attribution', $mofile_core );
			} else {
				// Load the default language files.
				load_plugin_textdomain( 'simple-attribution', false, $lang_dir );
			}
		}
	}
}


/**
 * The main function responsible for returning the one true Simple_Attribution
 * instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without
 * needing to declare the global.
 *
 * Example: <?php $simple_attribution = Simple_Attribution(); ?>
 *
 * @since       2.0.0
 * @return      Simple_Attribution The one true Simple_Attribution
 */
function simple_attribution() {
	return Simple_Attribution::instance();
}

// Get things started.
Simple_Attribution();
