<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package           DmvContactForm
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package     DmvContactForm
 * @subpackage  DmvContactForm/admin
 * @author      Dmitry Vasilenko <dmv.developer@gmail.com>
 */
class Dmv_CForm_Admin {

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
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

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
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dmv-cform-admin.css', array(), $this->version, 'all' );

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
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Admin menu
	 */
	public function admin_menu() {
		add_menu_page(
			"DMV Contact Form",
			"DMV Contact Form",
			"manage_options",
			"smashing_fields",
			array( $this, 'settings_page' ),
			"dashicons-email",
			100
		);
	}

	/**
	 * Setting page
	 */
	public function settings_page() {
		?>
        <div class="wrap">
            <h1>DMV Contact Form Options Page</h1>
            <form method="post" action="options.php">
				<?php
				settings_fields( "smashing_fields" );
				do_settings_sections( "smashing_fields" );
				submit_button();
				?>
            </form>
        </div>
		<?php
	}

	public function display_name_element() {
		?>
        <input type="text"
               name="dmv_name"
               id="dmv_name"
               value="<?php echo get_option( 'dmv_name' ); ?>"
               placeholder="Default: Name"/>
		<?php
	}

	public function display_email_element() {
		?>
        <input type="text"
               name="dmv_email"
               id="dmv_email"
               value="<?php echo get_option( 'dmv_email' ); ?>"
               placeholder="Default: Email"/>
		<?php
	}

	public function display_subject_element() {
		?>
        <input type="text"
               name="dmv_subject"
               id="dmv_subject"
               value="<?php echo get_option( 'dmv_subject' ); ?>"
               placeholder="Default: Subject"/>
		<?php
	}

	public function display_message_element() {
		?>
        <input type="text"
               name="dmv_message"
               id="dmv_message"
               value="<?php echo get_option( 'dmv_message' ); ?>"
               placeholder="Default: Message"/>
		<?php
	}

	public function display_success_msg_element() {
		?>
        <input type="text"
               name="dmv_success_message"
               id="dmv_success_message"
               value="<?php echo get_option( 'dmv_success_message' ); ?>"
               placeholder=""/>
		<?php
	}

	public function setup_sections() {
		add_settings_section( "main_section", "All Settings", array( $this, 'section_callback' ), "smashing_fields" );
		add_settings_section( "msg_section", "Message Settings", array(
			$this,
			'section_callback'
		), "smashing_fields" );
	}

	public function setup_fields() {
		add_settings_field( "dmv_name", "Name label", array(
			$this,
			"display_name_element"
		), "smashing_fields", "main_section" );
		add_settings_field( "dmv_email", "Email label text", array(
			$this,
			"display_email_element"
		), "smashing_fields", "main_section" );
		add_settings_field( "dmv_subject", "Subject label text", array(
			$this,
			"display_subject_element"
		), "smashing_fields", "main_section" );
		add_settings_field( "dmv_message", "Message label text", array(
			$this,
			"display_message_element"
		), "smashing_fields", "main_section" );
		add_settings_field( "dmv_success_message", "Success submit text", array(
			$this,
			"display_success_msg_element"
		), "smashing_fields", "msg_section" );

		register_setting( "smashing_fields", "dmv_name" );
		register_setting( "smashing_fields", "dmv_email" );
		register_setting( "smashing_fields", "dmv_subject" );
		register_setting( "smashing_fields", "dmv_message" );
		register_setting( "smashing_fields", "dmv_success_message" );
	}

	public function section_callback( $arguments ) {
		switch ( $arguments['id'] ) {
			case 'main_section':
				echo 'A super simple  contact form plugin. Here you can change the names of the fields label to adjust to your language.';
				break;
			case 'msg_section':
				echo 'The success message text.';
				break;
		}
	}

}
