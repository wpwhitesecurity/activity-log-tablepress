<?php
/*
	Filter in our custom functions into WSAL.
 */
add_filter( 'wsal_event_objects', 'wsal_tablepress_add_custom_event_objects', 10, 2 );
add_filter( 'wsal_event_type_data', 'wsal_tablepress_add_custom_event_type', 10, 2 );

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
