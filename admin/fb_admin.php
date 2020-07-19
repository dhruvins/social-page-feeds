<?php

/**
 * Master Blog Reader
 *
 * Admin File for Configuring Blogs
 *
 * @author      Dhruvin Shah
 * @package     blog-reader
 */

if ( !class_exists( 'FB_Admin' ) ) {
	
	/**
	 * Admin Class for Blog Reader
	 */
	class FB_Admin {
		
		function __construct() {
			
			add_action( 'admin_init', array( &$this, 'fb_register_settings' ) );
			add_action( 'admin_menu', array( &$this, 'fb_add_menu' ) );

			add_action( 'admin_enqueue_scripts', array( &$this, 'fb_admin_scripts' ) );
		}

		public function fb_add_menu() {
			add_menu_page(
				__( 'Facebook Page Data', 'fb-pages' ),
				__( 'Facebook Page Data', 'fb-pages' ),
				'manage_options',
				'fb-pages',
				array( &$this, 'fb_page_settings' ),
				'dashicons-facebook',
				7
			);
		}

		public function fb_register_settings() {

			register_setting( 
				'fb_page_api_settings',
				'fb_settings',
				array( &$this, 'fb_validate_settings' )
			);

			add_settings_section(
				'fb_settings_section',
				__( 'Facebook Page Settings', 'fb-pages' ),
				array( &$this, 'fb_section_callback' ),
				'fb_page_api_settings'
			);

			add_settings_field(
				'blog_site_url',
				__( 'Facebook Page ID', 'fb-pages' ),
				array( &$this, 'fb_settings_callback' ),
				'fb_page_api_settings',
				'fb_settings_section',
				array( __( 'ID of the Facebook Page', 'fb-pages' ) )
			);

			add_settings_field(
				'blog_site_shortcode',
				__( 'Shortcode', 'fb-pages' ),
				array( &$this, 'br_shortcode_callback' ),
				'fb_page_api_settings',
				'fb_settings_section',
				array( __( 'URL of the site whose Blog needs to be fetched', 'fb-pages' ) )
			);

		}

		public function fb_validate_settings( $input ) {

			$output = array( 'fb_page_id' => array() );
			$index = 1;

			if ( isset( $input['fb_page_id'] ) ) {

				foreach ( $input['fb_page_id'] as $key => $value ) {
					if ( $value !== '' ) {
						$output['fb_page_id'][$index] = $value;
						$index++;
					}
				}
			}

			return $output;
		}

		public function fb_page_settings() {

			settings_errors();

			print( "<form action='options.php' method='post'>" );
			settings_fields( 'fb_page_api_settings' );
			do_settings_sections( 'fb_page_api_settings' );
			submit_button ( __( 'Save Settings', 'fb-pages' ), 'primary', 'save', true );
			print( "</form>" );
		}

		public function fb_section_callback() {

			_e( 'Configure your settings', 'fb-pages' );
		}

		public function fb_settings_callback() {

			$options = get_option( 'fb_settings' );
			$total_count = count( $options['fb_page_id'] ) > 0 ? count( $options['fb_page_id'] ) : 1;

			for ( $rows = 1; $rows <= $total_count; $rows++ ) :

				$site_url = '';
				if( isset( $options['fb_page_id'][$rows] ) ){
					$site_url = $options['fb_page_id'][$rows];
				}
				?>

				<div id="row" class="row">
					<label for="fb_settings[fb_page_id][<?php echo $rows;?>]">
						<?php _e( 'Enter the site URL from where you want to fetch the posts', 'fb-pages' );?>
					</label></br>
					<input type='text' 
						id="fb_settings[fb_page_id][<?php echo $rows;?>]" 
						name="fb_settings[fb_page_id][<?php echo $rows;?>]" 
						value=<?php echo $site_url;?>
						>
				</div>

				<?php
			endfor;

			?>
			<input 
				type="button" 
				id="add_page_id" 
				class="button-primary br_class" 
				name="add_page_id" 
				data-count="<?php echo $total_count++;?>" 
				value="Add Page" />
			<?php
		}

		public function br_shortcode_callback() {

			?>

			<div class="row">
				<label>
					<?php _e( '<code>[fb-pages-shortcode]</code> Insert this shortcode on the pages you want', 'fb-pages' ); ?>
				</label>
			</div>

			<?php
		}

		public function fb_admin_scripts() {

			wp_register_script( 'fb_admin', plugins_url() . '/facebook-pages/assets/js/fb_admin.js', '', '', true );
			wp_enqueue_script( 'fb_admin' );
		}
	}
}

return new FB_Admin();