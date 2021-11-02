<?php

$custom_alerts = [
    __( 'TablePress', 'wsal-tablepress' ) => [
        __( 'Monitor TablePress', 'wsal-tablepress' ) => [

            [
                8900,
                WSAL_MEDIUM,
                __( 'A table was created', 'wsal-tablepress' ),
                __( 'Added the new table %table_name%.', 'wsal-tablepress' ),

                [
                    __( 'Table ID', 'wsal-tablepress' ) => '%table_id%',
                    __( 'Number of rows', 'wsal-tablepress' ) => '%rows%',
                    __( 'Number of columns', 'wsal-tablepress' ) => '%columns%',
                ],
                [
                    __( 'View in the editor', 'wsal-tablepress' ) => '%EditorLink%',
                ],
                'tablepress_tables',
                'added',
            ],

            [
                8901,
                WSAL_HIGH,
                __( 'A table was deleted', 'wsal-tablepress' ),
                __( 'Deleted the table %table_name%.', 'wsal-tablepress' ),

                [
                    __( 'Table ID', 'wsal-tablepress' ) => '%table_id%',
                ],
                [],
                'tablepress_tables',
                'deleted',
            ],

            [
                8902,
                WSAL_MEDIUM,
                __( 'A table was duplicated', 'wsal-tablepress' ),
                __( 'Created a copy of the table %table_name%.', 'wsal-tablepress' ),

                [
                    __( 'New table name', 'wsal-tablepress' ) => '%new_table_name%',
                    __( 'New table ID', 'wsal-tablepress' ) => '%table_id%',
                ],
                [
                    __( 'View in the editor', 'wsal-tablepress' ) => '%EditorLink%',
                ],
                'tablepress_tables',
                'added',
            ],

            [
                8903,
                WSAL_MEDIUM,
                __( 'A table was imported', 'wsal-tablepress' ),
                __( 'Imported the table %table_name%.', 'wsal-tablepress' ),

                [
                    __( 'Table ID', 'wsal-tablepress' ) => '%table_id%',
                ],
                [
                    __( 'View in the editor', 'wsal-tablepress' ) => '%EditorLink%',
                ],
                'tablepress_tables',
                'imported',
            ],


            [
                8904,
                WSAL_MEDIUM,
                __( 'A table ID was changed', 'wsal-tablepress' ),
                __( 'Changed the ID of the table %table_name%.', 'wsal-tablepress' ),

                [
                    __( 'Previous table ID', 'wsal-tablepress' ) => '%old_table_id%',
                    __( 'New table ID', 'wsal-tablepress' ) => '%table_id%',
                ],
                [
                    __( 'View in the editor', 'wsal-tablepress' ) => '%EditorLink%',
                ],
                'tablepress_tables',
                'updated',
            ],


            [
                8905,
                WSAL_MEDIUM,
                __( 'A table was modified', 'wsal-tablepress' ),
                __( 'Made changes to the table %table_name%', 'wsal-tablepress' ),

                [
                    __( 'Table ID', 'wsal-tablepress' ) => '%table_id%',
                    __( 'Number of rows', 'wsal-tablepress' ) => '%rows%',
                    __( 'Number of columns', 'wsal-tablepress' ) => '%columns%',
                    __( 'Previous number of rows', 'wsal-tablepress' ) => '%old_rows%',
                    __( 'Previous number of columns', 'wsal-tablepress' ) => '%old_columns%',
                ],
                [
                    __( 'View in the editor', 'wsal-tablepress' ) => '%EditorLink%',
                ],
                'tablepress_tables',
                'updated',
            ],

            [
                8906,
                WSAL_MEDIUM,
                __( 'A table row was added or removed', 'wsal-tablepress' ),
                __( 'A row was added or removed from the table %table_name%', 'wsal-tablepress' ),

                [
                    __( 'Table ID', 'wsal-tablepress' ) => '%table_id%',
                    __( 'Previous row count', 'wsal-tablepress' ) => '%old_count%',
                    __( 'New row count', 'wsal-tablepress' ) => '%count%',
                ],
                [
                    __( 'View in the editor', 'wsal-tablepress' ) => '%EditorLink%',
                ],
                'tablepress_tables',
                'added',
            ],

            [
                8907,
                WSAL_MEDIUM,
                __( 'A table column was added or removed', 'wsal-tablepress' ),
                __( 'A column was added or removed from the table %table_name%', 'wsal-tablepress' ),

                [
                    __( 'Table ID', 'wsal-tablepress' ) => '%table_id%',
                    __( 'Previous column count', 'wsal-tablepress' ) => '%old_count%',
                    __( 'New column count', 'wsal-tablepress' ) => '%count%',
                ],
                [
                    __( 'View in the editor', 'wsal-tablepress' ) => '%EditorLink%',
                ],
                'tablepress_tables',
                'added',
            ],

            [
                8908,
                WSAL_MEDIUM,
                __( 'A table option was modified', 'wsal-tablepress' ),
                __( 'Changed the status of the table option %option_name% in %table_name%', 'wsal-tablepress' ),

                [
                    __( 'Table ID', 'wsal-tablepress' ) => '%table_id%',
                    __( 'Previous value', 'wsal-tablepress' ) => '%old_value%',
                    __( 'New value', 'wsal-tablepress' ) => '%new_value%',
                ],
                [
                    __( 'View in the editor', 'wsal-tablepress' ) => '%EditorLink%',
                ],
                'tablepress_tables',
                'modified',
            ],

        ],
    ],
];
