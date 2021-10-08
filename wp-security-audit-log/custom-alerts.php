<?php

$custom_alerts = [
    __( 'TablePress', 'wsal-tablepress' ) => [
        __( 'Monitor TablePress', 'wsal-tablepress' ) => [

            [
                8900,
                WSAL_LOW,
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

        ],
    ],
];
