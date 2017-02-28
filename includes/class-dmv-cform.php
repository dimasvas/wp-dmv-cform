<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @since      1.0.0
 *
 * @package    DmvContactForm
 * @subpackage DmvContactForm/includes
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
 * @package    DmvContactForm
 * @subpackage DmvContactForm/includes
 * @author     Dmitry Vasilenko <dmv.developer@gmail.com>
 */
class Dmv_CForm {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Dmv_CForm_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
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

		$this->plugin_name = 'dmv-cform';
		$this->version     = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		add_shortcode( 'dmv_contact_form', array( $this, 'cf_shortcode' ) );

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Dmv_CForm_Loader. Orchestrates the hooks of the plugin.
	 * - PDmv_CForm_i18n. Defines internationalization functionality.
	 * - Dmv_CForm_Admin. Defines all hooks for the admin area.
	 * - Dmv_CForm_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dmv-cform-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dmv-cform-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dmv-cform-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-dmv-cform-public.php';

		$this->loader = new Dmv_CForm_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Dmv_CForm_i18n();

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

		$plugin_admin = new Dmv_CForm_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'admin_menu' );
		$this->loader->add_action("admin_init", $plugin_admin, 'setup_sections' );
		$this->loader->add_action("admin_init", $plugin_admin, 'setup_fields' );

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
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Dmv_CForm_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'wp_ajax_dmv_handle_ajax_request', $plugin_public, 'dmv_handle_ajax_request' );
		$this->loader->add_action( 'wp_ajax_nopriv_dmv_handle_ajax_request', $plugin_public, 'dmv_handle_ajax_request' );
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
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Dmv_CForm_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Shortcode callback
	 * @return string
	 */
	public function cf_shortcode() {
		ob_start();
		//TODO: Move to partial
		echo $this->html_form_code();

		return ob_get_clean();
	}

	/**
	 * Html form itself
	 */
	private function html_form_code() {
		$ajax_url = admin_url( 'admin-ajax.php' );
		$ajax_url .= "?action=dmv_handle_ajax_request&_wpnonce=" . wp_create_nonce( 'dmv_handle_ajax_request' );

		$options = $this->get_options();

		$html = <<<HTML
     <form class="dmv-contact-form" action="$ajax_url" id="dmv-contact-form">
            <label for="name" class="dmv-required">{$options['name']}</label>
            <input type="text" name="dmv-name" id="name" placeholder="Name" required>

            <label for="email" class="dmv-required">{$options['email']}</label>
            <input type="email" name="dmv-email" id="email" placeholder="Email" required>

            <label for="subject" class="dmv-required">{$options['subject']}</label>
            <input type="text" name="dmv-subject" id="subject" placeholder="Subject" required>

            <label for="message" class="dmv-required" required>{$options['message']}</label>
            <textarea name="dmv-message" id="message" placeholder="Message"></textarea>

            <input type="submit" name="cf-submitted" value="Send"/>
            <div id="success-msg">{$options['success_msg']}</div>
        </form>
HTML;

		return $html;
	}

	/**
	 * Get options from database
	 * @return array
	 */
	private function get_options() {
		$name_label = get_option( 'dmv_name' );
		$email_label = get_option( 'dmv_email' );
		$subject_label = get_option( 'dmv_subject' );
		$message_label = get_option( 'dmv_message' );
		$success_label = get_option( 'dmv_success_message' );

		return array(
			'name' => $name_label ? $name_label : 'Name',
			'email' => $email_label ? $email_label : 'Email',
			'subject' => $subject_label ? $subject_label : 'Subject',
			'message' => $message_label ? $message_label : 'Message',
			'success_msg' => $success_label ? $success_label : 'Form Submitted!',
		);
	}
}
