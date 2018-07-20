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
		wp_enqueue_script( $this->plugin_name.'-swal2', plugin_dir_url( __FILE__ ) . 'js/libs/swal2/swal2.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'-angular', plugin_dir_url( __FILE__ ) . 'js/angular.min.js', array( $this->plugin_name.'-swal2' ), $this->version, false );
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
    	add_menu_page( 'Ultimate GDPR Consent', 'Ultimate GDPR', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page') );

	}

	public function initialize_plugin_options() {

		// If the plugin options don't exist, create them.
		if( false == get_option( $this->plugin_name ) ) {
			add_option( $this->plugin_name );
		} // end if

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
		$valid['cookie_bar_status'] = $input['cookie_bar_status'];
		$valid['cookie_decline_button'] = $input['cookie_decline_button'];
		$valid['cookie_bar_position'] = $input['cookie_bar_position'];
		$valid['cookie_bar_header_float'] = $input['cookie_bar_header_float'];

		$valid['cookie_bar_show_condition'] = $input['cookie_bar_show_condition'];

		$valid['cookie_bar_auto_hide'] = $input['cookie_bar_auto_hide'];

		$valid['cookie_bar_auto_hide_delay'] = $input['cookie_bar_auto_hide_delay'];

		$valid['cookie_bar_hide_animation'] = $input['cookie_bar_hide_animation'];

		$valid['custom_allowed_cookies'] = $input['custom_allowed_cookies'];

		// Cookie Toggle Button options
		$valid['cookie_toggle_button']['status'] = $input['cookie_toggle_button']['status'];
		$valid['cookie_toggle_button']['text'] = $input['cookie_toggle_button']['text'];
		$valid['cookie_toggle_button']['background_color'] = $input['cookie_toggle_button']['background_color'];
		$valid['cookie_toggle_button']['text_color'] = $input['cookie_toggle_button']['text_color'];
		$valid['cookie_toggle_button']['show_border'] = $input['cookie_toggle_button']['show_border'];
		$valid['cookie_toggle_button']['border_color'] = $input['cookie_toggle_button']['border_color'];

		// Cookie Bar options
		$valid['cookie_bar']['message'] = $input['cookie_bar']['message'];
		$valid['cookie_bar']['background_color'] = $input['cookie_bar']['background_color'];
		$valid['cookie_bar']['text_color'] = $input['cookie_bar']['text_color'];
		$valid['cookie_bar']['show_border'] = $input['cookie_bar']['show_border'];
		$valid['cookie_bar']['border_color'] = $input['cookie_bar']['border_color'];

		// Accept Button options
		$valid['accept_button']['text'] = $input['accept_button']['text'];
		$valid['accept_button']['action'] = $input['accept_button']['action'];
		$valid['accept_button']['url'] = $input['accept_button']['url'];
		$valid['accept_button']['target'] = $input['accept_button']['target'];
		$valid['accept_button']['text_color'] = $input['accept_button']['text_color'];
		$valid['accept_button']['show_as'] = $input['accept_button']['show_as'];
		$valid['accept_button']['background_color'] = $input['accept_button']['background_color'];

		// Decline Button options
		$valid['decline_button']['text'] = $input['decline_button']['text'];
		$valid['decline_button']['action'] = $input['decline_button']['action'];
		$valid['decline_button']['url'] = $input['decline_button']['url'];
		$valid['decline_button']['target'] = $input['decline_button']['target'];
		$valid['decline_button']['text_color'] = $input['decline_button']['text_color'];
		$valid['decline_button']['show_as'] = $input['decline_button']['show_as'];
		$valid['decline_button']['background_color'] = $input['decline_button']['background_color'];

		return $valid;
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
