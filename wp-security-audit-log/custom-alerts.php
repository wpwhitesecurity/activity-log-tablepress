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
                    __( 'Old table ID', 'wsal-tablepress' ) => '%old_table_id%',
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
                ],
                [
                    __( 'View in the editor', 'wsal-tablepress' ) => '%EditorLink%',
                ],
                'tablepress_tables',
                'updated',
            ],

        ],
    ],
];
