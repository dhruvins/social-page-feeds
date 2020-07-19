<?php 
/**
 * Plugin Name: Social Page Feeds
 * Plugin URI: https://www.imaginate-solutions.com/
 * Description: This plugin lets you data of multiple Facebook Pages together
 * Version: 1.0.0
 * Author: Dhruvin Shah
 * Author URI: http://www.imaginate-solutions.com/
 * Requires PHP: 5.6
 */

/**
 * Exit if accessed directly
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; 
}

/**
 * Base class
 */
if ( !class_exists( 'Facebook_Pages' ) ) {

	/**
	 * Main Plugin Class
	 */
	class Facebook_Pages {
		
		function __construct() {
			
			self::fb_include_files();
		}

		public static function fb_include_files() {

			self::include_admin_files();
			self::include_frontend_files();
			self::include_files();
		}

		public static function include_admin_files() {

			include_once 'admin/fb_admin.php';
		}

		public static function include_frontend_files() {
			
			include_once 'frontend/fb_frontend.php';
		}

		public static function include_files() {
			
			include_once 'includes/fb_shortcode.php';
		}
	}
}

$fb_pages = new Facebook_Pages();
