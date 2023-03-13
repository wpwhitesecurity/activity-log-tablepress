<?php
/**
 * Custom Alerts for Table Press plugin.
 *
 * Class file for alert manager.
 *
 * @since   1.0.0
 *
 * @package wsal
 * @subpackage wsal-gravity-forms
 */

declare(strict_types=1);

namespace WSAL\Custom_Alerts;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( '\WSAL\Custom_Alerts\Tablepress_Custom_Alerts' ) ) {
	/**
	 * Custom sensor for Gravity Forms plugin.
	 *
	 * @since latest
	 */
	class Tablepress_Custom_Alerts {

		/**
		 * Returns the structure of the alerts for extension.
		 *
		 * @return array
		 *
		 * @since latest
		 */
		public static function get_custom_alerts(): array {
			return array(
				__( 'TablePress', 'wsal-tablepress' ) => array(
					__( 'Monitor TablePress', 'wsal-tablepress' ) => array(

						array(
							8900,
							WSAL_MEDIUM,
							__( 'A table was created', 'wsal-tablepress' ),
							__( 'Added the new table %table_name%.', 'wsal-tablepress' ),

							array(
								__( 'Table ID', 'wsal-tablepress' ) => '%table_id%',
								__( 'Number of rows', 'wsal-tablepress' ) => '%rows%',
								__( 'Number of columns', 'wsal-tablepress' ) => '%columns%',
							),
							array(
								__( 'View in the editor', 'wsal-tablepress' ) => '%EditorLink%',
							),
							'tablepress_tables',
							'added',
						),

						array(
							8901,
							WSAL_HIGH,
							__( 'A table was deleted', 'wsal-tablepress' ),
							__( 'Deleted the table %table_name%.', 'wsal-tablepress' ),

							array(
								__( 'Table ID', 'wsal-tablepress' ) => '%table_id%',
							),
							array(),
							'tablepress_tables',
							'deleted',
						),

						array(
							8902,
							WSAL_MEDIUM,
							__( 'A table was duplicated', 'wsal-tablepress' ),
							__( 'Created a copy of the table %table_name%.', 'wsal-tablepress' ),

							array(
								__( 'New table name', 'wsal-tablepress' ) => '%new_table_name%',
								__( 'New table ID', 'wsal-tablepress' ) => '%table_id%',
							),
							array(
								__( 'View in the editor', 'wsal-tablepress' ) => '%EditorLink%',
							),
							'tablepress_tables',
							'added',
						),

						array(
							8903,
							WSAL_MEDIUM,
							__( 'A table was imported', 'wsal-tablepress' ),
							__( 'Imported the table %table_name%.', 'wsal-tablepress' ),

							array(
								__( 'Table ID', 'wsal-tablepress' ) => '%table_id%',
							),
							array(
								__( 'View in the editor', 'wsal-tablepress' ) => '%EditorLink%',
							),
							'tablepress_tables',
							'imported',
						),

						array(
							8904,
							WSAL_MEDIUM,
							__( 'A table ID was changed', 'wsal-tablepress' ),
							__( 'Changed the ID of the table %table_name%.', 'wsal-tablepress' ),

							array(
								__( 'Previous table ID', 'wsal-tablepress' ) => '%old_table_id%',
								__( 'New table ID', 'wsal-tablepress' ) => '%table_id%',
							),
							array(
								__( 'View in the editor', 'wsal-tablepress' ) => '%EditorLink%',
							),
							'tablepress_tables',
							'updated',
						),

						array(
							8905,
							WSAL_MEDIUM,
							__( 'A table was modified', 'wsal-tablepress' ),
							__( 'Made changes to the table %table_name%', 'wsal-tablepress' ),

							array(
								__( 'Table ID', 'wsal-tablepress' ) => '%table_id%',
								__( 'Number of rows', 'wsal-tablepress' ) => '%rows%',
								__( 'Number of columns', 'wsal-tablepress' ) => '%columns%',
								__( 'Previous number of rows', 'wsal-tablepress' ) => '%old_rows%',
								__( 'Previous number of columns', 'wsal-tablepress' ) => '%old_columns%',
							),
							array(
								__( 'View in the editor', 'wsal-tablepress' ) => '%EditorLink%',
							),
							'tablepress_tables',
							'updated',
						),

						array(
							8906,
							WSAL_MEDIUM,
							__( 'A table row was added or removed', 'wsal-tablepress' ),
							__( 'A row was added or removed from the table %table_name%', 'wsal-tablepress' ),

							array(
								__( 'Table ID', 'wsal-tablepress' ) => '%table_id%',
								__( 'Previous row count', 'wsal-tablepress' ) => '%old_count%',
								__( 'New row count', 'wsal-tablepress' ) => '%count%',
							),
							array(
								__( 'View in the editor', 'wsal-tablepress' ) => '%EditorLink%',
							),
							'tablepress_tables',
							'added',
						),

						array(
							8907,
							WSAL_MEDIUM,
							__( 'A table column was added or removed', 'wsal-tablepress' ),
							__( 'A column was added or removed from the table %table_name%', 'wsal-tablepress' ),

							array(
								__( 'Table ID', 'wsal-tablepress' ) => '%table_id%',
								__( 'Previous column count', 'wsal-tablepress' ) => '%old_count%',
								__( 'New column count', 'wsal-tablepress' ) => '%count%',
							),
							array(
								__( 'View in the editor', 'wsal-tablepress' ) => '%EditorLink%',
							),
							'tablepress_tables',
							'added',
						),

						array(
							8908,
							WSAL_MEDIUM,
							__( 'A table option was modified', 'wsal-tablepress' ),
							__( 'Changed the status of the table option %option_name% in %table_name%', 'wsal-tablepress' ),

							array(
								__( 'Table ID', 'wsal-tablepress' ) => '%table_id%',
								__( 'Previous value', 'wsal-tablepress' ) => '%old_value%',
								__( 'New value', 'wsal-tablepress' ) => '%new_value%',
							),
							array(
								__( 'View in the editor', 'wsal-tablepress' ) => '%EditorLink%',
							),
							'tablepress_tables',
							'modified',
						),

					),
				),
			);
		}
	}
}
