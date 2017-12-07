<?php

return [
    'dt_format_d_m_y_h_i'           => 'd.m.Y H:i',
    'google_map_api_key' => 'AIzaSyDO-LuuLwKqMr_TKtOlnboMidjcfqkkxBw',
    'stat_importer' => [
        /**
         * row_to_start_from -  row with first brand name in file
         */
        'row_to_start_from' => 7,
        'stat_file_path'    => 'app/media/brands_statistics/brands_statistics.json',
        'nomenclature_path' => 'app/media/brands_statistics/nomenclatures/nomenclature_imported.xls',
        'years'             => [
            'previous_year_indexes' => [
                'row' => 5,
                'col' => 6,
            ],
            'current_year_indexes'  => [
                'row' => 5,
                'col' => 5,
            ],
            'percentage_indexes'  => [
                'row' => 5,
                'col' => 7,
            ]
        ],
        'months_indexes'    => [
            5, 8, 11, 14, 17, 20, 23, 26, 29, 32, 35, 38,
        ]
    ],
];