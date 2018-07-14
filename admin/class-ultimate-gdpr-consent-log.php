<?php

class Ultimate_Gdpr_Consent_Log {

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

    public function update_usermeta_consent($cookies){
        $user_id = get_current_user_id();
        if (!$user_id) {
            return false;
        }

        $current_cookies = get_user_meta( $user_id, 'ultimate_gdpr_consent_cookies', true );
        if(!$current_cookies || empty($current_cookies) || !is_array($current_cookies)) {
            update_usermeta( $user_id, 'ultimate_gdpr_consent_cookies', $cookies );
        } else {
            $cookies = array_merge($current_cookies, $cookies);
            update_usermeta( $user_id, 'ultimate_gdpr_consent_cookies', $cookies );
        }
    }

}
