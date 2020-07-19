<?php

/**
 * Master Blog Reader
 *
 * Admin File for Configuring Blogs
 *
 * @author      Dhruvin Shah
 * @package     blog-reader
 */

if ( !class_exists( 'FB_Page_Shortcodes' ) ) {

	/**
	 * Class for including other functionalities
	 */
	class FB_Page_Shortcodes {
		
		function __construct() {

			add_action( 'wp_enqueue_scripts', array( &$this, 'fb_pages_scripts' ) );

			add_shortcode( 'fb-pages-shortcode', array( &$this, 'fb_shortcode_callback' ) );
		}

		public function fb_shortcode_callback( $attrs ) {

			wp_enqueue_script( 'fb_pages_script' );
			
			$page_settings = get_option( 'fb_settings' );

			$page_ids = isset( $page_settings['fb_page_id'] ) ? $page_settings['fb_page_id'] : '';

			$fb_pages = '';

			foreach ( $page_ids as $fb_value ) {
				if ( $fb_value !== '' ) {
					$fb_pages .= '
						<div class="fb-page" 
							data-href="https://www.facebook.com/' . $fb_value . '"
							data-width="380" 
							data-hide-cover="false"
							data-show-facepile="false"></div>';
				}
			}

			return $fb_pages;
		}

		public function fb_pages_scripts() {
			
			wp_register_script( 
				'fb_pages_script', 
				'https://connect.facebook.net/de_DE/sdk.js#xfbml=1&version=v2.6',
				'',
				'1.0.0',
				false );
		}
	}
}

return new FB_Page_Shortcodes();