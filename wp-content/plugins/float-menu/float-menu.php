<?php
/**
 * Plugin Name:       Float Menu Lite
 * Plugin URI:        https://wordpress.org/plugins/float-menu/
 * Description:       Easily create floating menus of varying complexity
 * Version:           3.5
 * Author:            Wow-Company
 * Author URI:        https://wow-estore.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

namespace float_menu_free;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'Wow_Plugin' ) ) :

	/**
	 * Main Wow_Plugin Class.
	 *
	 * @since 1.0
	 */

	final class Wow_Plugin {

		private static $_instance;

		const PREF = 'fmp';

		public static function instance() {

			if ( ! isset( self::$_instance ) && ! ( self::$_instance instanceof Wow_Plugin ) ) {

				$info = array(
					'plugin' => array(
						'name'      => esc_attr__( 'Float Menu' ), // Plugin name
						'menu'      => esc_attr__( 'Float Menu' ), // Plugin name in menu
						'author'    => 'Wow-Company', // Author
						'prefix'    => self::PREF, // Prefix for database
						'text'      => 'float-menu',    // Text domain for translate files
						'version'   => '3.5', // Current version of the plugin
						'file'      => __FILE__, // Main file of the plugin
						'slug'      => dirname( plugin_basename( __FILE__ ) ), // Name of the plugin folder
						'url'       => plugin_dir_url( __FILE__ ), // filesystem directory path for the plugin
						'dir'       => plugin_dir_path( __FILE__ ), // URL directory path for the plugin
						'shortcode' => 'Float-Menu',

					),
					'url'    => array(
						'author'   => 'https://wow-estore.com/',
						'home'     => 'https://wordpress.org/plugins/float-menu/',
						'support'  => 'https://wordpress.org/support/plugin/float-menu/',
						'pro'      => 'https://wow-estore.com/item/float-menu-pro/',
						'facebook' => 'https://www.facebook.com/wowaffect/',
					),
					'rating' => array(
						'website'  => esc_attr__( 'WordPress.org' ), // Name site for rating plugin
						'url'      => 'https://wordpress.org/support/plugin/float-menu/reviews/#new-post',
						'wp_url'   => 'https://wordpress.org/support/plugin/float-menu/reviews/#new-post',
						'wp_home'  => 'https://wordpress.org/plugins/float-menu/',
						'wp_title' => 'Float menu – awesome floating side menu',
					),
				);

				self::$_instance = new Wow_Plugin;

				register_activation_hook( __FILE__, array( self::$_instance, 'plugin_activate' ) );
				add_action( 'plugins_loaded', array( self::$_instance, 'text_domain' ) );

				self::$_instance->_includes();
				self::$_instance->admin  = new Wow_Plugin_Admin( $info );
				self::$_instance->public = new Wow_Plugin_Public( $info );

			}

			return self::$_instance;
		}

		/**
		 * Throw error on object clone.
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @return void
		 * @since  1.0
		 * @access protected
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_attr__( 'Cheatin&#8217; huh?', 'floating-button' ), '0.1' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @return void
		 * @since  1.0
		 * @access protected
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_attr__( 'Cheatin&#8217; huh?', 'floating-button' ), '0.1' );
		}


		/**
		 * Include required files.
		 *
		 * @access private
		 * @return void
		 * @since  1.0
		 */
		private function _includes() {
			if ( ! class_exists( 'Wow_Company' ) ) {
				include_once 'includes/class-wow-company.php';
			}

			include_once 'admin/class-admin.php';
			include_once 'public/class-public.php';
		}

		/**
		 * Activate the plugin.
		 * create the database
		 * create the folder in wp-upload
		 *
		 * @access public
		 * @return void
		 * @since  1.0
		 */
		public function plugin_activate() {
			update_option( 'wow_' . self::PREF . '_notice_action', 'read' );
			include_once 'includes/plugin-activation.php';
		}

		/**
		 * Download the folder with languages.
		 *
		 * @access public
		 * @return void
		 * @since  1.0
		 */
		public function text_domain() {
			$languages_folder = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
			load_plugin_textdomain( 'floating-button', false, $languages_folder );
		}

	}

endif; // End if class_exists check.

	/**
	 * The main function for that returns Wow_Plugin
	 *
	 * @since 1.0
	 */
	function Wow_Plugin_run() {
		return Wow_Plugin::instance();
	}

// Get Running.
	Wow_Plugin_run();
