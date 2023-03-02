<?php
/**
 * Filter in our custom functions into WSAL.
 */

use WSAL\Helpers\Classes_Helper;

add_filter( 'wsal_event_objects', 'wsal_tablepress_add_custom_event_objects', 10, 2 );
add_filter( 'wsal_event_type_data', 'wsal_tablepress_add_custom_event_type', 10, 2 );
add_filter( 'wsal_ignored_custom_post_types', 'wsal_tablepress_add_custom_ignored_cpt' );

/**
 * Register a custom event object within WSAL.
 *
 * @param array $objects array of objects current registered within WSAL.
 */
function wsal_tablepress_add_custom_event_objects( $objects ) {
	$new_objects = array(
		'tablepress_tables' => esc_html__( 'TablePress', 'wsal-tablepress' ),
	);

	// combine the two arrays.
	$objects = array_merge( $objects, $new_objects );

	return $objects;
}

function wsal_tablepress_add_custom_event_type( $types ) {
 	$new_types = array(
		'imported' => __( 'Imported', 'wsal-tablepress' ),
 	);

 	// combine the two arrays.
 	$types = array_merge( $types, $new_types );

 	return $types;
}

/**
 * Adds new ignored CPT for our plugin
 *
 * @method wsal_tablepress_add_custom_ignored_cpt
 * @since  1.0.0
 * @param  array $post_types An array of default post_types.
 * @return array
 */
function wsal_tablepress_add_custom_ignored_cpt( $post_types ) {
	$new_post_types = array(
		'tablepress_table',
	);

	// combine the two arrays.
	$post_types = array_merge( $post_types, $new_post_types );
	return $post_types;
}

add_action(
	'wsal_sensors_manager_add',
	/**
	* Adds sensors classes to the Class Helper
	*
	* @return void
	*
	* @since latest
	*/
	function () {
		require_once __DIR__ . '/../wp-security-audit-log/sensors/class-tablepress-sensor.php';

		Classes_Helper::add_to_class_map(
			array(
				'WSAL\\Plugin_Sensors\\TablePress_Sensor' => __DIR__ . '/../wp-security-audit-log/sensors/class-tablepress-sensor.php',
			)
		);
	}
);

