<?php
/**
 * Custom Sensors for TablePress
 * Class file for alert manager.
 *
 * @since   1.0.0
 * @package Wsal
 */
class WSAL_Sensors_TablePress extends WSAL_AbstractSensor {

	/**
	 * Holds a cached value if the checked alert has recently fired.
	 *
	 * @var null|array
	 */
	private $cached_alert_checks = null;

	/**
	 * Hook events related to sensor.
	 *
	 * @since 1.0.0
	 */
	public function HookEvents() {
		if ( is_user_logged_in() ) {
			// do_action( 'tablepress_event_saved_table', $table_id );
			// do_action( 'tablepress_event_added_table', $table_id );
			// do_action( 'tablepress_event_copied_table', $new_table_id, $table_id );
			// do_action( 'tablepress_event_deleted_table', $table_id );
			// do_action( 'tablepress_event_deleted_all_tables' );
			// do_action( 'tablepress_event_changed_table_id', $new_id, $old_id );

			// add_action( 'tablepress_event_saved_table', [ $this, 'event_table_saved' ] );
			
			// add_action( 'tablepress_event_deleted_all_tables', [ $this, 'event_all_tabels_deleted' ] );
			// add_action( 'tablepress_event_changed_table_id', [ $this, 'event_table_id_change' ], 10, 2 );

			add_action( 'tablepress_event_added_table', [ $this, 'event_table_added' ] );
			add_action( 'tablepress_event_deleted_table', [ $this, 'event_table_deleted' ] );
			add_action( 'tablepress_event_copied_table', [ $this, 'event_table_copied' ], 10, 2 );
			add_action( 'tablepress_event_changed_table_id', [ $this, 'event_table_id_change' ], 10, 2 );
			add_action( 'tablepress_event_saved_table', [ $this, 'event_table_saved' ] );
		}
	}

	public function event_table_added( $table_id ) {
		$editor_link = esc_url(
			add_query_arg(
				array(
					'table_id' => $table_id,
					'action'   => 'edit',
				),
				admin_url( 'admin.php?page=tablepress' )
			)
		);

		$event_id = ( isset( $_POST['action'] ) && 'tablepress_import' == $_POST['action'] ) ? 8903 : 8900;

		$variables = array(
			'table_name' => sanitize_text_field( get_the_title( $table_id ) ),
			'table_id'   => $table_id,
			'columns'    => ( isset( $_POST[ 'table' ] ) ) ? intval( $_POST[ 'table' ][ 'columns' ] ) : 0,
			'rows'       => ( isset( $_POST[ 'table' ] ) ) ? intval( $_POST[ 'table' ][ 'rows' ] ) : 0,
			'EditorLink' => $editor_link,
		);

		$this->plugin->alerts->Trigger( $event_id, $variables );

		return;
	}	

	public function event_table_deleted( $table_id ) {
		$variables = array(
			'table_name' => sanitize_text_field( get_the_title( $table_id ) ),
			'table_id'   => $table_id,
		);

		$this->plugin->alerts->Trigger( 8901, $variables );

		return;
	}
	
	public function event_table_copied( $new_table_id, $table_id ) {
		$editor_link = esc_url(
			add_query_arg(
				array(
					'table_id' =>  $new_table_id,
					'action'   =>  'edit',
				),
				admin_url( 'admin.php?page=tablepress' )
			)
		);

		$variables = array(
			'table_name'     => sanitize_text_field( get_the_title( $table_id ) ),
			'new_table_name' => sanitize_text_field( get_the_title( $new_table_id ) ),
			'table_id'       => $new_table_id,
		);

		$this->plugin->alerts->Trigger( 8902, $variables );

		return;
	}

	public function event_table_id_change( $new_id, $old_id ) {
		$editor_link = esc_url(
			add_query_arg(
				array(
					'table_id' =>  $new_id,
					'action'   =>  'edit',
				),
				admin_url( 'admin.php?page=tablepress' )
			)
		);

		$variables = array(
			'table_name'   => sanitize_text_field( get_the_title( $old_id) ),
			'old_table_id' => $old_id,
			'table_id'     => $new_id,
		);

		$this->plugin->alerts->Trigger( 8904, $variables );

		return;
	}

	public function event_table_saved(  $table_id ) {
		$editor_link = esc_url(
			add_query_arg(
				array(
					'table_id' =>   $table_id,
					'action'   =>  'edit',
				),
				admin_url( 'admin.php?page=tablepress' )
			)
		);

		$variables = array(
			'table_name' => sanitize_text_field( get_the_title( $table_id ) ),
			'table_id'   => $table_id,
		);

		$this->plugin->alerts->Trigger( 8905, $variables );

		return;
	}
}
