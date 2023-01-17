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
	 * Holds the table ID assigned to the table during import.
	 *
	 * @var null|int
	 */
	private $imported_table_id = null;

	/**
	 * Holds the post ID assigned to the table during deketion.
	 *
	 * @var null|int
	 */
	private $deleted_table_title = null;

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

			add_action( 'deleted_post', [ $this, 'event_table_pre_deleted' ] );
			add_action( 'tablepress_event_deleted_table', [ $this, 'event_table_deleted' ] );

			add_action( 'tablepress_event_copied_table', [ $this, 'event_table_copied' ], 10, 2 );
			add_action( 'tablepress_event_changed_table_id', [ $this, 'event_table_id_change' ], 10, 2 );
			add_action( 'wp_insert_post', [ $this, 'event_table_imported' ] );
			add_action( 'post_updated', [ $this, 'event_table_updated' ], 10, 3 );
		}
	}

	/**	
	 * Repoort changes to tables such as row changes, setting changes etc.
	 * 
	 * @since 1.0.0
	 * 
	 * @param int $post id
	 * @param object WP_Post object
	 * @param object WP_Post object
	 */
	function event_table_updated( $post_ID, $post_after, $post_before ){
		if ( isset( $_POST['action'] ) && 'tablepress_save_table' == $_POST['action'] ) {
			$editor_link = esc_url(
				add_query_arg(
					array(
						'table_id' => $_POST['tablepress']['id'],
						'action'   => 'edit',
					),
					admin_url( 'admin.php?page=tablepress' )
				)
			);		

			$table_id = $_POST['tablepress']['id'];
			
			$old_table_details = ( isset( $this->_old_meta['_tablepress_table_options'][0] ) ) ? json_decode( $this->_old_meta['_tablepress_table_options'][0], true ) : [];
	
			// Remove part we are not interested in.
			if ( isset( $old_table_details['last_editor'] ) ) {
				unset( $old_table_details['last_editor']  );
			}
	
			$new_table_options = ( isset( $_POST['tablepress']['options'] ) ) ? json_decode( wp_unslash( $_POST['tablepress']['options'] ), true ) : [];
	
			$changed      = array_diff_assoc( $new_table_options, $old_table_details );
			$bool_options = [ 'table_head', 'table_foot', 'alternating_row_colors', 'row_hover', 'use_datatables', 'print_name', 'print_description', 'datatables_sort', 'datatables_filter', 'datatables_paginate', 'datatables_lengthchange', 'datatables_info', 'datatables_scrollx' ];
			$alert_needed = false;
	
			if ( ! class_exists( 'TablePress_Table_Model' ) ) {
				return;
			}
	
			$tablepress    = new TablePress_Table_Model;
			$table_details = $tablepress->load( $_POST['tablepress']['id'] );

			if ( $post_after->post_content != $post_before->post_content || $post_after->post_title != $post_before->post_title || $post_after->post_excerpt != $post_before->post_excerpt ) {
				$explode_to_rows   = explode( '],', $post_after->post_content );
				$number_of_rows    = count( $explode_to_rows  );
				$number_of_columns = count( explode( ',', reset( $explode_to_rows ) ) );
				
				$alert_id = 8905;
				$variables = array(
					'table_name'  => $post_after->post_title,
					'table_id'    => $_POST['tablepress']['id'],
					'columns'     => ( $number_of_columns ) ? intval( $number_of_columns ) : 0,
					'rows'        => ( isset( $number_of_rows ) ) ? intval( $number_of_rows ) : 0,
					'old_columns' => $this->_old_column_count,
					'old_rows'    => $this->_old_row_count,
					'EditorLink'  => $editor_link,
				);
				$alert_needed = true;
			}
			
			// Detect and report setting changes.
			if ( ! empty( $changed ) ) {
				foreach ( $changed as $updated_table_setting => $value ) {
					// Tidy up name to something useful.
					if ( 'table_foot' == $updated_table_setting ) {
						$updated_name = esc_html__( 'The last row of the table is the table footer', 'wsal-tablepress' );
					} else if ( 'table_head' == $updated_table_setting ) {
						$updated_name = esc_html__( 'The first row of the table is the table header', 'wsal-tablepress' );
					} else if ( 'alternating_row_colors' == $updated_table_setting ) {
						$updated_name = esc_html__( 'The background colors of consecutive rows shall alternate', 'wsal-tablepress' );
					} else if ( 'row_hover' == $updated_table_setting ) {
						$updated_name = esc_html__( 'Highlight a row while the mouse cursor hovers above it by changing its background color', 'wsal-tablepress' );
					} else if ( 'use_datatables' == $updated_table_setting ) {
						$updated_name = esc_html__( 'Use the following features of the DataTables JavaScript library with this table', 'wsal-tablepress' );
					} else if ( 'print_name' == $updated_table_setting ) {
						$updated_name = esc_html__( 'Show the table name', 'wsal-tablepress' );
					} else if ( 'print_description' == $updated_table_setting ) {
						$updated_name = esc_html__( 'Show the table description', 'wsal-tablepress' );
					} else if ( 'datatables_sort' == $updated_table_setting ) {
						$updated_name = esc_html__( 'Enable sorting of the table by the visitor.', 'wsal-tablepress' );
					} else if ( 'datatables_filter' == $updated_table_setting ) {
						$updated_name = esc_html__( 'Enable the visitor to filter or search the table.' );
					} else if ( 'datatables_paginate' == $updated_table_setting ) {
						$updated_name = esc_html__( 'Enable pagination of the table', 'wsal-tablepress' );
					} else if ( 'datatables_lengthchange' == $updated_table_setting ) {
						$updated_name = esc_html__( 'Allow the visitor to change the number of rows shown when using pagination.', 'wsal-tablepress' );
					} else if ( 'datatables_info' == $updated_table_setting ) {
						$updated_name = esc_html__( 'Enable the table information display', 'wsal-tablepress' );
					} else if ( 'datatables_scrollx' == $updated_table_setting ) {
						$updated_name = esc_html__( 'Enable horizontal scrolling', 'wsal-tablepress' );
					} else if ( 'print_name_position' == $updated_table_setting ) {
						$updated_name = esc_html__( 'Table name position', 'wsal-tablepress' );
					} elseif ( 'print_description_position' == $updated_table_setting ) {
						$updated_name = esc_html__( 'Table description position', 'wsal-tablepress' );
					} elseif ( 'extra_css_classes' == $updated_table_setting ) {
						$updated_name = esc_html__( 'Extra CSS Classes', 'wsal-tablepress' );
					} elseif ( 'datatables_paginate_entries' == $updated_table_setting ) {
						$updated_name = esc_html__( 'Table pagignation length', 'wsal-tablepress' );
					} elseif ( 'datatables_custom_commands' == $updated_table_setting ) {
						$updated_name = esc_html__( 'Custom table commands', 'wsal-tablepress' );
					}
					
					$alert_id = 8908;
					if ( in_array( $updated_table_setting , $bool_options ) ) {
						$value = ( empty( $value ) ) ? 'disabled' : 'enabled';
					}
					if ( in_array( $updated_table_setting , $bool_options ) ) {
						$old_value = ( empty( $new_table_options[$updated_table_setting] ) ) ? 'enabled': 'disabled';
					} else {
						$old_value = $old_table_details[$updated_table_setting];
					}

					$variables = array(
						'table_name'   => sanitize_text_field( $table_details['name'] ),
						'table_id'     => $table_id,
						'option_name'  => $updated_name,							
						'new_value'    => $value,
						'old_value'    => $old_value,
						'EventType'    => ( $new_table_options[$updated_table_setting] ) ? 'enabled' : 'disabled',
						'EditorLink'   => $editor_link,
					);
					$this->plugin->alerts->Trigger( $alert_id, $variables );
				}		
			} 			
	
			// Detect new or removed columns.
			if ( isset( $_POST['tablepress']['number']['columns'] ) && intval( $_POST['tablepress']['number']['columns'] ) != $this->_old_column_count ) {
				$event_type = ( $this->_old_column_count > intval( $_POST['tablepress']['number']['columns'] ) ) ? 'removed' : 'added';
				$alert_id = 8907;
				$variables = array(
					'table_name'    => sanitize_text_field( $table_details['name'] ),
					'table_id'      => $table_id,
					'count'         => ( isset( $_POST['tablepress']['number']['columns'] ) ) ? intval( $_POST['tablepress']['number']['columns'] ) : 0,
					'old_count'     => $this->_old_column_count,
					'EventType'     => $event_type,
					'EditorLink'   => $editor_link,
				);	
				$alert_needed = true;
			
			// Detect new or removed rows.
			} else if ( isset( $_POST['tablepress']['number']['rows'] ) && intval( $_POST['tablepress']['number']['rows'] ) != $this->_old_row_count ) {
				$event_type = ( $this->_old_row_count > intval( $_POST['tablepress']['number']['rows'] ) ) ? 'removed' : 'added';
				$alert_id = 8906;
				$variables = array(
					'table_name'    => sanitize_text_field( $table_details['name'] ),
					'table_id'      => $table_id,
					'count'         => ( isset( $_POST['tablepress']['number']['rows'] ) ) ? intval( $_POST['tablepress']['number']['rows'] ) : 0,
					'old_count'     => $this->_old_row_count,
					'EventType'     => $event_type,
					'EditorLink'    => $editor_link,
				);	
				$alert_needed = true;			
			}
			
			if ( $alert_needed ) {
				// Do alert.
				$this->plugin->alerts->Trigger( $alert_id, $variables );
			}
	
			return;
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
			'table_name' => sanitize_text_field( get_the_title( $this->imported_table_id ) ),
			'table_id'   => $table_id,
			'columns'    => ( isset( $_POST[ 'table' ] ) ) ? intval( $_POST[ 'table' ][ 'columns' ] ) : 0,
			'rows'       => ( isset( $_POST[ 'table' ] ) ) ? intval( $_POST[ 'table' ][ 'rows' ] ) : 0,
			'EditorLink' => $editor_link,
		);

		$this->plugin->alerts->Trigger( $event_id, $variables );

		return;
	}	


	/**
	 * Grab correct table name before deletion.
	 *
	 * @since 1.0.0
	 *
	 * @param int $table_id - Table ID.
	 */
	public function event_table_pre_deleted( $table_id ) {
		$this->deleted_table_title = sanitize_text_field( get_the_title( $table_id ) );
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
			'table_name' => $this->deleted_table_title,
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

		if ( ! class_exists( 'TablePress_Table_Model' ) ) {
			return;
		}

		$tablepress = new TablePress_Table_Model;
		$old_table  = $tablepress->load( $table_id );
		$new_table  = $tablepress->load( $new_table_id );


		$variables = array(
			'table_name'     => sanitize_text_field( $old_table['name'] ),
			'new_table_name' => sanitize_text_field( $new_table['name'] ),
			'table_id'       => $new_table_id,
			'EditorLink'     => $editor_link,
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

		if ( ! class_exists( 'TablePress_Table_Model' ) ) {
			return;
		}

		$tablepress    = new TablePress_Table_Model;
		$table_details = $tablepress->load( $new_id );

		$variables = array(
			'table_name'   => sanitize_text_field( $table_details['name'] ),
			'old_table_id' => $old_id,
			'table_id'     => $new_id,
			'EditorLink'   => $editor_link,
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

	}

	/**
	 * Detect imported tabled.
	 *
	 * @since 1.0.0
	 *
	 * @param int $table_id - Table ID.
	 */
	public function event_table_imported( $table_id ) {
		$this->imported_table_id = $table_id;
		return;
	}

}
