<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.wpexec.com
 * @since      1.0.0
 *
 * @package    Ultimate_Gdpr_Consent
 * @subpackage Ultimate_Gdpr_Consent/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ultimate_Gdpr_Consent
 * @subpackage Ultimate_Gdpr_Consent/public
 * @author     WPExec <wpexec.com@gmail.com>
 */
class Ultimate_Gdpr_Consent_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function default_options($options){
		// setup array of defaults
		$defaults = array(
			'cookie_bar_status'			=>	'1',
			'cookie_bar_position' 		=>	'footer',
			'cookie_bar_show_condition'	=>	'instant',
			'cookie_bar_auto_hide' 		=>	'0',
			'cookie_bar_auto_hide_delay'=>	'5000',
			'cookie_bar_hide_animation'	=>	'1',
			'cookie_decline_button'		=>	'1',
			'custom_allowed_cookies'	=>	'wordpress_test_cookie,wordpress_logged_in_,wordpress_sec,wp-settings',
			'cookie_bar_header_float'	=>	'float',
			'cookie_age'				=>	'180',
			'cookie_bar' => array(
				'message'			=>	'This site uses cookies to provide you with a more responsive and personalized service. By using this site you agree to our use of cookies. Please read our cookie notice for more information on the cookies we use and how to delete or block them.',
				'background_color'	=>	'rgba(33, 33, 33, 0.8)',
				'text_color'		=>	'rgba(255, 255, 255, 1)',
				'show_border'		=>	'0',
				'border_color'		=>	'rgba(0, 0, 0, 1)',
				'scroll_offset'		=>	'150'
			),
			'cookie_toggle_button' => array(
				'status'			=>	'1',
				'text'				=>	'Cookies & Privacy Policy',
				'background_color'	=>	'rgba(33, 33, 33, 0.8)',
				'text_color'		=>	'rgba(255, 255, 255, 1)',
				'show_border'		=>	'0',
				'border_color'		=>	'rgba(0, 0, 0, 1)',
			),
			'accept_button' => array(
				'text'				=>	'Accept',
				'action'			=>	'hide',
				'text_color'		=>	'rgba(255, 255, 255, 1)',
				'show_as'			=>	'button',
				'background_color'	=>	'rgba(255, 69, 0, 1)',
			),
			'decline_button' => array(
				'text'				=>	'Decline',
				'action'			=>	'hide',
				'text_color'		=>	'rgba(255, 255, 255, 1)',
				'show_as'			=>	'link',
				'background_color'	=>	'transparent',
			),
			'policy_update'	=>	array(
				'from'				=>	get_option('admin_email'),
				'from_name'			=>	get_option('blogname'),
				'subject'			=>	__('Updates to our Privacy Policy'),
				'message'			=>	__('Hello %s! We hve updates our privacy policy.'),
			),
			'data_breach'	=>	array(
				'from'				=>	get_option('admin_email'),
				'from_name'			=>	get_option('blogname'),
				'subject'			=>	__('Data Breach'),
				'message'			=>	__('Hello %s! Recently, there is a security incident. To secure your account, you\'ll need to login to your account and change a new password.'),
			)
		);

		// merge options with defaults
		$options = wp_parse_args( $options, $defaults );
		return $options;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ultimate-gdpr-consent-public.css', array(), $this->version, 'all' );
		wp_add_inline_style($this->plugin_name, $this->custom_css());

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ultimate-gdpr-consent-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'ultimate_gdrp_content_options', $this->localize_vars() );

	}

	public function localize_vars() {
		$options = get_option($this->plugin_name);
		$strings = array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'auto_hide_delay'	=>	isset($options['cookie_bar_auto_hide_delay']) ? $options['cookie_bar_auto_hide_delay'] : 5000,
			'scroll_offset'	=>	isset($options['cookie_bar']['scroll_offset']) ? $options['cookie_bar']['scroll_offset'] : 150,
		);
		return $strings;
	}

	public function custom_css() {
		$options = get_option($this->plugin_name);
		$custom_css = "";

		$cookie_bar_bg = $options['cookie_bar']['background_color'];
		$cookie_bar_text_color = $options['cookie_bar']['text_color'];
		$cookie_bar_border_color = $options['cookie_bar']['border_color'];
		$accept_button_bg = $options['accept_button']['show_as'] == 'button' ? $options['accept_button']['background_color'] : 'transparent';
		$decline_button_bg = $options['decline_button']['show_as'] == 'button' ? $options['decline_button']['background_color'] : 'transparent';

		$cookie_toggle_bg = $options['cookie_toggle_button']['background_color'];
		$cookie_toggle_text_color = $options['cookie_toggle_button']['text_color'];
		$cookie_toggle_border_color = $options['cookie_toggle_button']['border_color'];

		$custom_css .= "
			.ugc-cookie-bar {
				background-color: {$cookie_bar_bg};
			}
			.ugc-cookie-bar .ugc-cookie-message {
				color: {$cookie_bar_text_color};
			}
			.ugc-cookie-bar .ugc-button.ugc-button-accept {
				background: {$accept_button_bg};
				color: {$options['accept_button']['text_color']};
			}
			.ugc-cookie-bar .ugc-button.ugc-button-decline {
				background: {$decline_button_bg};
				color: {$options['decline_button']['text_color']};
			}
			#ugc-cookie-toggle {
				background: {$cookie_toggle_bg};
				color: {$cookie_toggle_text_color};
			}
		 ";

		if ($options['cookie_bar']['show_border'] === '1') {
			$custom_css .= "
				.ugc-cookie-bar.ugc-bordered {
					border-top-color: $cookie_bar_border_color !important;
					border-bottom-color: $cookie_bar_border_color !important;
				}
			";
		}

		if ($options['cookie_toggle_button']['show_border'] === '1') {
			$custom_css .= "
				#ugc-cookie-toggle {
					border-top: 2px;
					border-left: 2px;
					border-right: 2px;
					border-color: {$cookie_toggle_border_color};
					border-style: solid;
				}
			";
		}

		 return $custom_css;
	}

	public function ugc_body_classes($classes) {
		$options = get_option($this->plugin_name);
		$cookies_options = $this->check_cookies_options();
		if (isset($options['cookie_bar_position']) && $options['cookie_bar_position'] === 'header'
		&& isset($options['cookie_bar_header_float']) && $options['cookie_bar_header_float'] === 'static'
		&& (!isset($cookies_options['is_allowed']) && ($cookies_options['is_allowed'] === true)
		OR !isset($cookies_options['is_declined']) && ($cookies_options['is_declined'] === true))
		) {
			$classes[] = 'ugc-padded-top';
		}
		return $classes;
	}

	public function ugc_cookie_bar_classes(){
		$options = get_option($this->plugin_name);
		$cookies_options = $this->check_cookies_options();
		$classes = [];
		$classes[] = isset($options['cookie_bar_position']) && $options['cookie_bar_position'] === 'header' ? 'ugc-fixed-top' : 'ugc-fixed-bottom';
		$classes[] = isset($options['cookie_bar_show_condition']) && $options['cookie_bar_show_condition'] === 'scroll' ? 'ugc-show-scroll ugc-hidden' : 'ugc-show-instant';
		$classes[] = isset($options['cookie_bar_auto_hide']) && $options['cookie_bar_auto_hide'] === '1' ? 'ugc-auto-hide' : '';
		$classes[] = isset($options['cookie_bar_hide_animation']) && $options['cookie_bar_hide_animation'] === '0' ? 'ugc-hide-no-animation' : '';
		$classes[] = isset($options['cookie_bar']['show_border']) && $options['cookie_bar']['show_border'] === '1' ? 'ugc-bordered' : '';

		$classes[] = isset($cookies_options['is_declined']) && $cookies_options['is_declined'] === true ? 'ugc-declined ugc-hidden' : '';
		$classes[] = isset($cookies_options['is_allowed']) && $cookies_options['is_allowed'] === true ? 'ugc-allowed ugc-hidden' : '';
		return implode(" ", $classes);
	}

	/**
	*
	*
	* @since 		1.0.0
	*/
	public function add_cookie_bar() {
		$options = get_option($this->plugin_name);
		$cookies_options = $this->check_cookies_options();

		// var_dump($options);

		$decline_button = "";
		$decline_href = "#";
		$decline_target = isset($options['decline_button']['target']) ? $options['decline_button']['target'] : '_self';
		$decline_classes = "";
		if (isset($options['cookie_decline_button']) && $options['cookie_decline_button'] == 1) {
			if (isset($options['decline_button']['action']) && $options['decline_button']['action'] == 'url' && isset($options['decline_button']['url'])) {
				$decline_href = $options['decline_button']['url'];
				$decline_classes = "ugc-button-url";
			}
			$decline_button .= '<a href="'.$decline_href.'" target="'.$decline_target.'" id="ugc-button-decline" class="ugc-button ugc-button-decline '.$decline_classes.'">'.$options['decline_button']['text'].'</a>';
		}

		$accept_button = "";

		$accept_href = "#";
		$accept_target = isset($options['accept_button']['target']) ? $options['accept_button']['target'] : '_self';
		$accept_classes = "";
		if (isset($options['accept_button']['action']) && $options['accept_button']['action'] == 'url' && isset($options['accept_button']['url'])) {
			$accept_href = $options['accept_button']['url'];
			$accept_classes = "ugc-button-url";
		}
		$accept_button .= '<a href="'.$accept_href.'" id="ugc-button-accept" target="'.$decline_target.'" class="ugc-button ugc-button-accept '.$decline_classes.'">'.$options['accept_button']['text'].'</a>';

		$container_class = $this->ugc_cookie_bar_classes();

		$ugc_toggle_class = "";
		if (isset($cookies_options['is_allowed']) && $cookies_options['is_allowed'] === false && isset($cookies_options['is_declined']) && $cookies_options['is_declined'] === false) {
			$ugc_toggle_class = "ugc-toggle-hide";
		}

		if (isset($options['cookie_bar_status']) && $options['cookie_bar_status'] == 1) {
			echo '
				<div id="ugc-cookie-bar" class="ugc-cookie-bar ugc-fixed-float '.$container_class.'">
					<div class="ugc-container">
						<div class="ugc-flex ugc-cookie-message">
							This site uses cookies to provide you with a more responsive and personalized service. By using this site you agree to our use of cookies. Please read our cookie notice for more information on the cookies we use and how to delete or block them.
						</div>
						<div class="ugc-flex ugc-actions">
							'.$accept_button.'
							'.$decline_button.'
						</div>
					</div>
				</div>
			';
		}

		if (isset($options['cookie_toggle_button']['status']) && $options['cookie_toggle_button']['status'] == '1') {
			echo '
				<div id="ugc-cookie-toggle" class="'.$ugc_toggle_class.'">
					<span id="ugc-cookie-toggle-text">Cookies & Privacy Policy</span>
				</div>
			';
		}

	}

	public function check_cookies_options(){

		$is_allowed = isset($_COOKIE['ultimate_gdpr_consent_cookies_allowed']);
		$is_declined = false;

		if(isset($_COOKIE['ultimate_gdpr_consent_cookies_declined']) && ($_COOKIE['ultimate_gdpr_consent_cookies_declined'] == "true")) {
			$is_declined = true;
		}

		if(current_user_can('administrator')) {
			// $is_allowed = true;
		}

		$return_data = array('is_allowed' => $is_allowed, 'is_declined' => $is_declined);

		if (isset($_POST['action']) && $_POST['action'] == 'ultimate_gdpr_consent_check_cookies_options') {
			echo json_encode($return_data);
		} else {
			return $return_data;
		}
        wp_die();
	}

	public function allow_cookies(){
		$options = get_option($this->plugin_name);
		$cookie_lifetime = $options['cookie_age'];
		$cookie_lifetime = time() + ($cookie_lifetime * 60 * 60 * 24);

		$cookies = array(
			'ultimate_gdpr_consent_cookies_allowed' => 'true',
            'ultimate_gdpr_consent_cookies_declined' => 'false',
		);

        foreach ($cookies as $cookie => $value) {
            setcookie($cookie, $value, $cookie_lifetime, '/');
        }

		do_action('ultimate_gdpr_consent_allow_cookies', $cookies);

		wp_die();
	}

	public function decline_cookies(){
		$options = get_option($this->plugin_name);
		$cookie_lifetime = $options['cookie_age'];
		$cookie_lifetime = time() + ($cookie_lifetime * 60 * 60 * 24);
		setcookie('ultimate_gdpr_consent_cookies_declined', 'true', $cookieLifetime, '/');

		$allowed_cookies = array(
            'woocommerce_cart_hash',
            'woocommerce_items_in_cart',
            '__cfduid',
            'ultimate_gdpr_consent_cookies_allowed',
            'ultimate_gdpr_consent_cookies_declined',
        );

		$custom_allowed_cookies = $options['custom_allowed_cookies'];
		if (isset($custom_allowed_cookies) && !empty($custom_allowed_cookies)) {
			$custom_allowed_cookies = array_map('trim', explode(',', $custom_allowed_cookies));
			if (is_array($custom_allowed_cookies) && !empty($custom_allowed_cookies)) {
				$allowed_cookies = array_merge($allowed_cookies, $custom_allowed_cookies);
			}
		}

		do_action('ultimate_gdpr_consent_decline_cookies', array('ultimate_gdpr_consent_cookies_declined' => 'true') );

		$this->delete_not_allowed_cookies($allowed_cookies);

		wp_die();
	}

	public function delete_not_allowed_cookies($allowed_cookies, $allow_all = false){
		if ($allow_all) return;
		$past = time() - 3600;
		// $domain
		foreach ( $_COOKIE as $key => $value ) {
			if(!empty($allowed_cookies)) {
				foreach ($allowed_cookies as $allowed_cookie) {
					if (strpos($key, $allowed_cookie) !== FALSE) {
						continue 2;
					}
				}
			}
			setcookie( $key, $value, $past, '/');
			// setcookie( $key, $value, $past, '/', $domain);
			setcookie( $key, $value, $past);
		}
	}

}
