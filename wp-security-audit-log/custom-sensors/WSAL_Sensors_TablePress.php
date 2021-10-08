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
			// Gather up old data where we can.
			add_action( 'pre_post_update', array( $this, 'get_before_post_edit_data' ), 10, 2 );

			add_action( 'tablepress_event_added_table', [ $this, 'event_table_added' ] );
			add_action( 'tablepress_event_deleted_table', [ $this, 'event_table_deleted' ] );
			add_action( 'tablepress_event_copied_table', [ $this, 'event_table_copied' ], 10, 2 );
			add_action( 'tablepress_event_changed_table_id', [ $this, 'event_table_id_change' ], 10, 2 );
			add_action( 'tablepress_event_saved_table', [ $this, 'event_table_saved' ] );
		}
	}

	/**
	 * Get Post Data.
	 *
	 * Collect old post data before post update event.
	 *
	 * @since 1.0.0
	 *
	 * @param int $table_id - Table ID.
	 */
	public function get_before_post_edit_data( $table_id ) {
		$table_id   = absint( $table_id ); // Making sure that the post id is integer.
		$table      = get_post( $table_id ); // Get post.
		$table_meta = get_post_meta( $table_id ); // Get post

		$explode_to_rows   = explode( '],', $table->post_content );
		$number_of_rows    = count( $explode_to_rows  );
		$number_of_columns = count( explode( ',', reset( $explode_to_rows ) ) );

		// If post exists.
		if ( ! empty( $table ) ) {
			$this->_old_table = $table;
			$this->_old_row_count    = $number_of_rows;
			$this->_old_column_count = $number_of_columns;
			$this->_old_meta         = $table_meta;
		}
	}

	/**
	 * Report new Tables being created.
	 *
	 * Collect old post data before post update event.
	 *
	 * @since 1.0.0
	 *
	 * @param int $table_id - Table ID.
	 */
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

	/**
	 * Report table deletions.
	 *
	 * Collect old post data before post update event.
	 *
	 * @since 1.0.0
	 *
	 * @param int $table_id - Table ID.
	 */
	public function event_table_deleted( $table_id ) {
		$variables = array(
			'table_name' => sanitize_text_field( get_the_title( $table_id ) ),
			'table_id'   => $table_id,
		);

		$this->plugin->alerts->Trigger( 8901, $variables );

		return;
	}

	/**
	 * Report duplication of a table.
	 *
	 * Collect old post data before post update event.
	 *
	 * @since 1.0.0
	 *
	 * @param int $new_table_id - Table ID.
	 * @param int $table_id - Original Table ID.
	 */
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

	/**
	 * Report change in a Table's ID.
	 *
	 * Collect old post data before post update event.
	 *
	 * @since 1.0.0
	 *
	 * @param int $new_id - Table ID.
	 * @param int $old_id - Old Table ID.
	 */
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

	/**
	 * Detect table changes.
	 *
	 * Collect old post data before post update event.
	 *
	 * @since 1.0.0
	 *
	 * @param int $table_id - Table ID.
	 */
	public function event_table_saved( $table_id ) {
		$editor_link = esc_url(
			add_query_arg(
				array(
					'table_id' =>   $table_id,
					'action'   =>  'edit',
				),
				admin_url( 'admin.php?page=tablepress' )
			)
		);
		
		$old_table_details = ( isset( $this->_old_meta['_tablepress_table_options'][0] ) ) ? json_decode( $this->_old_meta['_tablepress_table_options'][0], true ) : [];
		// Remove part we are not interested in.
		if ( isset( $old_table_details['last_editor'] ) ) {
			unset( $old_table_details['last_editor']  );
		}

		$new_table_options = ( isset( $_POST['tablepress']['options'] ) ) ? json_decode( str_replace( '\"', '"', $_POST['tablepress']['options'] ), true ) : [];

		$changed      = array_diff_assoc( $old_table_details, $new_table_options );
		$bool_options = [ 'table_head', 'table_foot', 'alternating_row_colors', 'row_hover'];
		
		if ( ! empty( $changed ) ) {
			foreach ( $changed as $updated_table_setting => $value ) {
				if ( in_array( $updated_table_setting , $bool_options ) ) {
					if ( 'table_foot' == $updated_table_setting ) {
						$updated_name = esc_html__( 'The last row of the table is the table footer.', 'wsal-tablepress' );
					} else if ( 'table_head' == $updated_table_setting ) {
						$updated_name = esc_html__( 'The first row of the table is the table header.', 'wsal-tablepress' );
					} else if ( 'alternating_row_colors' == $updated_table_setting ) {
						$updated_name = esc_html__( 'The background colors of consecutive rows shall alternate.', 'wsal-tablepress' );
					} else if ( 'row_hover' == $updated_table_setting ) {
						$updated_name = esc_html__( 'Highlight a row while the mouse cursor hovers above it by changing its background color.', 'wsal-tablepress' );
					}
					$alert_id = 8907;
					$variables = array(
						'table_name'  => sanitize_text_field( get_the_title( $table_id ) ),
						'table_id'    => $table_id,
						'option_name' => $updated_name,
						'EventType'   => ( $new_table_options[$updated_table_setting] ) ? 'enabled' : 'disabled',
					);
				}

			}
		} else {
			$alert_id = 8905;
			$variables = array(
				'table_name'  => sanitize_text_field( get_the_title( $table_id ) ),
				'table_id'    => $table_id,
				'columns'     => ( isset( $_POST['tablepress']['number']['columns'] ) ) ? intval( $_POST['tablepress']['number']['columns'] ) : 0,
				'rows'        => ( isset( $_POST['tablepress']['number']['rows'] ) ) ? intval( $_POST['tablepress']['number']['rows'] ) : 0,
				'old_columns' => $this->_old_column_count,
				'old_rows'    => $this->_old_row_count,
			);	
		}


		$this->plugin->alerts->Trigger( $alert_id, $variables );

		return;
	}
}
