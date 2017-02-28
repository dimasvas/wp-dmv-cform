<?php

/**
 * @since             1.0.0
 * @package           DmvContactForm
 *
 * @wordpress-plugin
 * Plugin Name:       Dmv Contact form
 * Description:       It is simple contact form plugin with ajax feature.
 * Version:           1.0.0
 * Author:            Dimitry Vasilenko
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dmv-cform
 * Domain Path:       /languages
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dmv_cform-activator.php
 */
function activate_dmv_cform() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dmv-cform-activator.php';
	Dmv_Cform_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dmv_cform-deactivator.php
 */
function deactivate_dmv_cform() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dmv_cform-deactivator.php';
	Dmv_CForm_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dmv_cform' );
register_deactivation_hook( __FILE__, 'deactivate_dmv_cform' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dmv-cform.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_dmv_cform() {

	$plugin = new Dmv_Cform();
	$plugin->run();

}

run_dmv_cform();
