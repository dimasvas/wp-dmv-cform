<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package           DmvContactForm
 * @subpackage Plugin_Name/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    DmvContactForm
 * @subpackage DmvContactForm/public
 * @author     Dmitry Vasilenko <dmv.developer@gmail.com>
 */
class Dmv_CForm_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

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
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dmv-cform-public.css', array(), $this->version, 'all' );

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
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dmv-cform-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 *  Handles Ajax request
	 *
	 * @since    1.0.0
	 */
	public function dmv_handle_ajax_request() {
		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {

			if ( array_key_exists( 'action', $_POST ) && $_POST['action'] === 'dmv_handle_ajax_request' ) {

				$nonce = $_REQUEST['_wpnonce'];

				if ( wp_verify_nonce( $nonce, 'dmv_handle_ajax_request' ) ) {

					$data = $this->process_data();

					$this->send_email( $data );

				} else {

					wp_send_json_error();
				}
			}
		}
	}

	/**
	 * Process form data
	 */
	private function process_data() {
		$params = array();
		parse_str( $_POST['form'], $params );

		/**
		 * Sanitize form values
		 */
		$name    = sanitize_text_field( $params["dmv-name"] );
		$email   = sanitize_email( $params["dmv-email"] );
		$subject = sanitize_text_field( $params["dmv-subject"] );
		$message = esc_textarea( $params["dmv-message"] );
		$headers = "From: $name <$email>" . "\r\n";

		return array(
			'to'      => get_option( 'admin_email' ),
			'subject' => $subject,
			'message' => $message,
			'headers' => $headers
		);
	}

	private function send_email( $data ) {
		wp_mail( $data['to'], $data['subject'], $data['message'], $data['headers'] ) ?
			wp_send_json_success() : wp_send_json_error();
	}

}
