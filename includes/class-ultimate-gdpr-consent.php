<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.wpexec.com
 * @since      1.0.0
 *
 * @package    Ultimate_Gdpr_Consent
 * @subpackage Ultimate_Gdpr_Consent/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Ultimate_Gdpr_Consent
 * @subpackage Ultimate_Gdpr_Consent/includes
 * @author     WPExec <wpexec.com@gmail.com>
 */
class Ultimate_Gdpr_Consent {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ultimate_Gdpr_Consent_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'ultimate-gdpr-consent';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ultimate_Gdpr_Consent_Loader. Orchestrates the hooks of the plugin.
	 * - Ultimate_Gdpr_Consent_i18n. Defines internationalization functionality.
	 * - Ultimate_Gdpr_Consent_Admin. Defines all hooks for the admin area.
	 * - Ultimate_Gdpr_Consent_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ultimate-gdpr-consent-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ultimate-gdpr-consent-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ultimate-gdpr-consent-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ultimate-gdpr-consent-log.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ultimate-gdpr-consent-policy-update.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ultimate-gdpr-consent-data-breach.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ultimate-gdpr-consent-public.php';

		$this->loader = new Ultimate_Gdpr_Consent_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Ultimate_Gdpr_Consent_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ultimate_Gdpr_Consent_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Ultimate_Gdpr_Consent_Admin( $this->get_plugin_name(), $this->get_version() );
		$plugin_public = new Ultimate_Gdpr_Consent_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_filter( 'option_'.$this->plugin_name, $plugin_public, 'default_options' );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'initialize_plugin_options' );

		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );
		$this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'options_update' );

		$this->log = new Ultimate_Gdpr_Consent_Log($this->get_plugin_name(), $this->get_version());
		$this->loader->add_action('ultimate_gdpr_consent_allow_cookies', $this->log, 'update_usermeta_consent', 10);
        $this->loader->add_action('ultimate_gdpr_consent_decline_cookies', $this->log, 'update_usermeta_consent', 10);

		// Ajax Actions
		$this->loader->add_action( 'wp_ajax_ugc_get_settings', $plugin_admin, 'get_options' );

		$this->policy_update = new Ultimate_Gdpr_Consent_Policy_Update($this->get_plugin_name(), $this->get_version());
		$this->loader->add_action( 'wp_ajax_ugc_send_policy_updates', $this->policy_update, 'send_policy_update' );

		$this->policy_update = new Ultimate_Gdpr_Consent_Data_Breach($this->get_plugin_name(), $this->get_version());
		$this->loader->add_action( 'wp_ajax_ugc_send_data_breach_email', $this->policy_update, 'send_data_breach_email' );
		// $this->loader->add_action( 'wp_ajax_nopriv_ugc_get_settings', $plugin_admin, 'get_options' ); // Save Setting



	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Ultimate_Gdpr_Consent_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_filter( 'option_'.$this->plugin_name, $plugin_public, 'default_options' );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'wp_ajax_ultimate_gdpr_consent_check_cookies_options', $plugin_public, 'check_cookies_options', 10 );
		$this->loader->add_action( 'wp_ajax_nopriv_ultimate_gdpr_consent_check_cookies_options', $plugin_public, 'check_cookies_options', 10 );
		$this->loader->add_action( 'wp_ajax_ultimate_gdpr_consent_allow_cookies', $plugin_public, 'allow_cookies', 10 );
		$this->loader->add_action( 'wp_ajax_nopriv_ultimate_gdpr_consent_allow_cookies', $plugin_public, 'allow_cookies', 10 );
		$this->loader->add_action( 'wp_ajax_ultimate_gdpr_consent_decline_cookies', $plugin_public, 'decline_cookies', 10 );
		$this->loader->add_action( 'wp_ajax_nopriv_ultimate_gdpr_consent_decline_cookies', $plugin_public, 'decline_cookies', 10 );

		// $this->loader->add_action( 'init', $plugin_public, 'init' );

		$this->loader->add_filter( 'body_class', $plugin_public, 'ugc_body_classes' );
		$this->loader->add_action( 'wp_footer', $plugin_public, 'add_cookie_bar', 10 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Ultimate_Gdpr_Consent_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
