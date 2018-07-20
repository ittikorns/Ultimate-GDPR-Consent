<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.wpexec.com
 * @since      1.0.0
 *
 * @package    Ultimate_Gdpr_Consent
 * @subpackage Ultimate_Gdpr_Consent/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ultimate_Gdpr_Consent
 * @subpackage Ultimate_Gdpr_Consent/admin
 * @author     WPExec <wpexec.com@gmail.com>
 */
class Ultimate_Gdpr_Consent_Admin {

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
		 * defined in Ultimate_Gdpr_Consent_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ultimate_Gdpr_Consent_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name.'-angular-color-picker', plugin_dir_url( __FILE__ ) . 'js/libs/angular-color-picker/angularjs-color-picker.min.css', array(), $this->version, false );
		wp_enqueue_style( $this->plugin_name.'-toastr', plugin_dir_url( __FILE__ ) . 'js/libs/toastr/toastr.min.css', array(), $this->version, false );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ultimate-gdpr-consent-admin.css', array(), $this->version, 'all' );

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
		 * defined in Ultimate_Gdpr_Consent_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ultimate_Gdpr_Consent_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// Color Pickers
		wp_enqueue_script( $this->plugin_name.'-tinycolor', plugin_dir_url( __FILE__ ) . 'js/libs/tinycolor/tinycolor.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'-toastr', plugin_dir_url( __FILE__ ) . 'js/libs/toastr/toastr.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'-angular', plugin_dir_url( __FILE__ ) . 'js/angular.min.js', array( $this->plugin_name.'-toastr' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'-angular-color-picker', plugin_dir_url( __FILE__ ) . 'js/libs/angular-color-picker/angularjs-color-picker.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ultimate-gdpr-consent-admin-min.js', array( 'jquery', $this->plugin_name.'-angular' ), $this->version, false );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

    /*
     * Add a settings page for this plugin to the Settings menu.
     *
     * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
     *
     *        Administration Menus: http://codex.wordpress.org/Administration_Menus
     *
     */
		$svg_icon = '<svg id="666da539-9a95-4458-8680-6eee8fc3d7e3" data-name="Layer 1 copy" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 252.2552 252.2601"><title>Ultimate GDPR Consent</title><polygon points="102.651 120.863 91.365 130.792 118.446 160.977 118.499 160.924 118.536 160.977 167.102 111.621 158.434 100.227 118.961 132.711 102.651 120.863" style="fill:#83878b;stroke:#fff;stroke-miterlimit:10;stroke-width:2px"/><path d="M141.729,17.6667a124.13,124.13,0,1,0,124.13,124.1275A124.1292,124.1292,0,0,0,141.729,17.6667Zm.0024,192.721c-63.8731,0-68.4229-108.0693-68.4229-108.0693L141.73,73.2h.0016l68.4214,29.1184S205.603,210.3877,141.7314,210.3877Z" transform="translate(-15.6039 -15.6667)" style="fill:#83878b;stroke:#fff;stroke-miterlimit:10;stroke-width:4px"/></svg>';

    	add_menu_page( 'Ultimate GDPR Consent', 'Ultimate GDPR', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'),  'data:image/svg+xml;base64,' . base64_encode($svg_icon) );

	}

	public function initialize_plugin_options() {

		// If the plugin options don't exist, create them.
		if( false == get_option( $this->plugin_name ) ) {
			add_option( $this->plugin_name );
		} // end if

		// Details link using API info, if available
		if ( isset( $plugin_data['slug'] ) && current_user_can( 'install_plugins' ) ) {
		    $plugin_meta[] = sprintf( '<a href="%s" class="thickbox" aria-label="%s" data-title="%s">%s</a>',
		        esc_url( network_admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $plugin_data['slug'] .
		            '&TB_iframe=true&width=600&height=550' ) ),
		        esc_attr( sprintf( __( 'More information about %s' ), $plugin_name ) ),
		        esc_attr( $plugin_name ),
		        __( 'View details' )
		    );
		} elseif ( ! empty( $plugin_data['PluginURI'] ) ) {
		    $plugin_meta[] = sprintf( '<a href="%s">%s</a>',
		        esc_url( $plugin_data['PluginURI'] ),
		        __( 'Visit plugin site' )
		    );
		}

	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */

	public function add_action_links( $links ) {
	    /*
	    *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
	    */
	   $settings_link = array(
	    '<a href="' . admin_url( 'admin.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
	   );
	   return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */

	public function display_plugin_setup_page() {
	  include_once( 'partials/ultimate-gdpr-consent-admin-display.php' );
	}

	/**
	 * Validate inputs
	 *
	 * @since    1.0.0
	 */
	public function validate($input) {
		// All checkboxes inputs
		$valid = array();
		// var_dump($input)
		//Cleanup
		$valid['cookie_bar_status'] = $this->isSetAndNotEmpty($input['cookie_bar_status']) ? "1" : "0";
		$valid['cookie_decline_button'] = $this->isSetAndNotEmpty($input['cookie_decline_button']) ? "1" : "0";
		$valid['cookie_bar_position'] = $this->isSetAndNotEmpty($input['cookie_bar_position']) ? $input['cookie_bar_position'] : 'footer';
		$valid['cookie_bar_header_float'] = $this->isSetAndNotEmpty($input['cookie_bar_header_float']) ? $input['cookie_bar_header_float'] : 'float';

		$valid['cookie_bar_show_condition'] = $this->isSetAndNotEmpty($input['cookie_bar_show_condition']) ? $input['cookie_bar_show_condition'] : 'instant';

		$valid['cookie_bar_auto_hide'] = $this->isSetAndNotEmpty($input['cookie_bar_auto_hide']) ? $input['cookie_bar_auto_hide'] : '0';

		$valid['cookie_bar_auto_hide_delay'] = $this->isSetAndNotEmpty($input['cookie_bar_auto_hide_delay']) ? (int) $input['cookie_bar_auto_hide_delay'] : 3000;

		$valid['cookie_bar_hide_animation'] = $this->isSetAndNotEmpty($input['cookie_bar_hide_animation']) ? $input['cookie_bar_hide_animation'] : '0';

		$valid['custom_allowed_cookies'] = $this->isSetAndNotEmpty($input['custom_allowed_cookies']) ? $input['custom_allowed_cookies'] : 'wordpress_test_cookie,wordpress_logged_in_,wordpress_sec,wp-settings';

		$valid['cookie_age'] = $this->isSetAndNotEmpty($input['cookie_age']) ? $input['cookie_age'] : '180';

		// Cookie Toggle Button options
		$valid['cookie_toggle_button']['status'] = $this->isSetAndNotEmpty($input['cookie_toggle_button']['status']) ? $input['cookie_toggle_button']['status'] : '1';
		$valid['cookie_toggle_button']['text'] = $this->isSetAndNotEmpty($input['cookie_toggle_button']['text']) ? $input['cookie_toggle_button']['text'] : 'Cookies & Privacy Policy';
		$valid['cookie_toggle_button']['background_color'] = $this->isSetAndNotEmpty($input['cookie_toggle_button']['background_color']) ? $input['cookie_toggle_button']['background_color'] : 'rgba(33, 33, 33, 0.8)';
		$valid['cookie_toggle_button']['text_color'] = $this->isSetAndNotEmpty($input['cookie_toggle_button']['text_color']) ? $input['cookie_toggle_button']['text_color'] : 'rgba(255, 255, 255, 1)';
		$valid['cookie_toggle_button']['show_border'] = $this->isSetAndNotEmpty($input['cookie_toggle_button']['show_border']) ? $input['cookie_toggle_button']['show_border'] : '0';
		$valid['cookie_toggle_button']['border_color'] = $this->isSetAndNotEmpty($input['cookie_toggle_button']['border_color']) ? $input['cookie_toggle_button']['border_color'] : 'rgba(0, 0, 0, 1)';

		// Cookie Bar options
		$valid['cookie_bar']['message'] = $this->isSetAndNotEmpty($input['cookie_bar']['message']) ? $input['cookie_bar']['message'] : 'This site uses cookies to provide you with a more responsive and personalized service. By using this site you agree to our use of cookies. Please read our cookie notice for more information on the cookies we use and how to delete or block them.';
		$valid['cookie_bar']['background_color'] = $this->isSetAndNotEmpty($input['cookie_bar']['background_color']) ? $input['cookie_bar']['background_color'] : 'rgba(33, 33, 33, 0.8)';
		$valid['cookie_bar']['text_color'] = $this->isSetAndNotEmpty($input['cookie_bar']['text_color']) ? $input['cookie_bar']['text_color'] : 'rgba(255, 255, 255, 1)';
		$valid['cookie_bar']['show_border'] = $this->isSetAndNotEmpty($input['cookie_bar']['show_border']) ? $input['cookie_bar']['show_border'] : '0';
		$valid['cookie_bar']['border_color'] = $this->isSetAndNotEmpty($input['cookie_bar']['border_color']) ? $input['cookie_bar']['border_color'] : 'rgba(0, 0, 0, 1)';
		$valid['cookie_bar']['scroll_offset'] = $this->isSetAndNotEmpty($input['cookie_bar']['scroll_offset']) ? $input['cookie_bar']['scroll_offset'] : '150';

		// Accept Button options
		$valid['accept_button']['text'] = $this->isSetAndNotEmpty($input['accept_button']['text']) ? $input['accept_button']['text'] : 'Accept';
		$valid['accept_button']['action'] = $this->isSetAndNotEmpty($input['accept_button']['action']) ? $input['accept_button']['action'] : 'hide';
		$valid['accept_button']['url'] = $this->isSetAndNotEmpty($input['accept_button']['url']) ? $input['accept_button']['url'] : '';
		$valid['accept_button']['target'] = $this->isSetAndNotEmpty($input['accept_button']['target']) ? $input['accept_button']['target'] : '_self';
		$valid['accept_button']['text_color'] = $this->isSetAndNotEmpty($input['accept_button']['text_color']) ? $input['accept_button']['text_color'] : '#FFFFFF';
		$valid['accept_button']['show_as'] = $this->isSetAndNotEmpty($input['accept_button']['show_as']) ? $input['accept_button']['show_as'] : 'text';
		$valid['accept_button']['background_color'] = $this->isSetAndNotEmpty($input['accept_button']['background_color']) ? $input['accept_button']['background_color'] : 'transparent';

		// Decline Button options
		$valid['decline_button']['text'] = $this->isSetAndNotEmpty($input['decline_button']['text']) ? $input['decline_button']['text'] : 'Decline';
		$valid['decline_button']['action'] = $this->isSetAndNotEmpty($input['decline_button']['action']) ? $input['decline_button']['action'] : 'hide';
		$valid['decline_button']['url'] = $this->isSetAndNotEmpty($input['decline_button']['url']) ? $input['decline_button']['url'] : '';
		$valid['decline_button']['target'] = $this->isSetAndNotEmpty($input['decline_button']['target']) ? $input['decline_button']['target'] : '_self';
		$valid['decline_button']['text_color'] = $this->isSetAndNotEmpty($input['decline_button']['text_color']) ? $input['decline_button']['text_color'] : '#FFFFFF';
		$valid['decline_button']['show_as'] = $this->isSetAndNotEmpty($input['decline_button']['show_as']) ? $input['decline_button']['show_as'] : 'text';
		$valid['decline_button']['background_color'] = $this->isSetAndNotEmpty($input['decline_button']['background_color']) ? $input['decline_button']['background_color'] : 'transparent';

		$valid['policy_update']['from'] = $this->isSetAndNotEmpty($input['policy_update']['from']) ? $input['policy_update']['from'] : get_option('admin_email');
		$valid['policy_update']['from_name'] = $this->isSetAndNotEmpty($input['policy_update']['from_name']) ? $input['policy_update']['from_name'] : get_option('blogname');
		$valid['policy_update']['subject'] = $this->isSetAndNotEmpty($input['policy_update']['subject']) ? $input['policy_update']['subject'] : __('Updates to our Privacy Policy');
		$valid['policy_update']['message'] = $this->isSetAndNotEmpty($input['policy_update']['message']) ? $input['policy_update']['message'] : __('Hello %s! We hve updates our privacy policy.');

		$valid['data_breach']['from'] = $input['data_breach']['from'];
		$valid['data_breach']['from_name'] = $input['data_breach']['from_name'];
		$valid['data_breach']['subject'] = $input['data_breach']['subject'];
		$valid['data_breach']['message'] = $input['data_breach']['message'];

		return $valid;
	}

	/**
	 * Helper function to check set and not empty variable
	 *
	 * @since 	1.0.0
	 * @param  variable  $var A variable to check
	 * @return boolean
	 */
	public function isSetAndNotEmpty($var) {
		if (isset($var) && ($var !== "")){
			return true;
		}
		return false;
	}

	/**
	 * Save inputs
	 *
	 * @since    1.0.0
	 */
	 public function options_update() {
		register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
		// wp_die();
	}

	/**
	 * Get Options
	 *
	 * @since    1.0.0
	 */
	 public function get_options() {
		$options = get_option($this->plugin_name);
		echo json_encode($options);
		wp_die();
	}


}
