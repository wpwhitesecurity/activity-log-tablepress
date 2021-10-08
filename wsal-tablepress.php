<?php
/**
 * Plugin Name: WP Activity Log Extension for TablePress
 * Plugin URI: https://wpactivitylog.com/extensions/
 * Description: A WP Activity Log plugin extension
 * Text Domain: wp-security-audit-log
 * Author: WP White Security
 * Author URI: http://www.wpwhitesecurity.com/
 * Version: 1.0.0
 * License: GPL2
 * Network: true
 *
 * @package WsalExtensionCore
 * @subpackage Wsal Custom Events Loader
 */

/*
 Copyright(c) 2020  WP White Security  (email : info@wpwhitesecurity.com)
 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License, version 2, as
 published by the Free Software Foundation.
 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.
 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
 REQUIRED. Here we include and fire up the main core class. This is crucial so leave intact.
*/
require_once plugin_dir_path( __FILE__ ) . 'core/class-extension-core.php';
$wsal_extension = new WPWhiteSecurity\ActivityLog\Extensions\Common\Core( __FILE__, 'wsal-tablepress' );

// Include extension specific functions.
require_once plugin_dir_path( __FILE__ ) . 'includes/wsal-functions.php';
