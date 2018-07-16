<?php

class Ultimate_Gdpr_Consent_Policy_Update {

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

    public function send_policy_update(){
		$options = get_option($this->plugin_name);

		$from = $options['policy_update']['from'];
		$from_name = $options['policy_update']['from_name'];
        $subject = $options['policy_update']['subject'];
		$message = $options['policy_update']['message'];

        $headers = array(
            'From: ' . $from_name . ' <' . $from . '>' . "\r\n",
            'Content-Type: text/html; charset=UTF-8'
        );

        $users = get_users();
        foreach ($users as $user) {
            $user_data = get_userdata($user->ID);

            if(empty($user_data->data->user_email) || !isset($user_data->data->user_email)) {
                continue;
            }

            $text = wpautop( sprintf( $message, $user_data->data->user_nicename) );
		//
            wp_mail($user_data->data->user_email, $subject, $text, $headers);
        }


		echo json_encode($headers);
		wp_die();
    }

}
