<?php

return [
    /*
     * If enable all SQL queries will be logged. This config should only be enabled in development
     * environment and don't be enable in production because affects the performance
     * of the application
     */
    'sql_debug_enable' => env('SOLPAC_SQL_DEBUG', false),

    'import' => [
        'endpoint' => 'https://webservice.aldo.com.br/asp.net/ferramentas/integracao.ashx',
        'username' => env('SUBSOLAR_IMPORT_USERNAME', '238168'),
        'password' => env('SUBSOLAR_IMPORT_PASSWORD', '3fv43n'),
    ],

    /*
     * Quantidade máxima de tentativa de geradores que iremos tentar adicionar.
     * Após exceder este limite a mensagem de "Não foi possível encontrar um conjunto de geradores"
     * será emitada para o usuário
     */
    'arrangement_max_size' => env('SUBSOLAR_ARRANGEMENT_MAX_SIZE', 40),

    'panels' => [
        [
            'id' => 'byd-nac',
            'name' => 'BYD',
            'power' => 0.400,
            'type' => 'POLI',
            'category' => 'panel',
            'utilArea' => 1.7974,
            'panelEfficiency' => 0.172,
            'systemEfficiency' => 0.86
        ],
        [
            'id' => 'trina',
            'name' => 'TRINA',
            'power' => 0.375,
            'type' => 'MONO',
            'category' => 'panel',
            'utilArea' => 1.7974,
            'panelEfficiency' => 0.197,
            'systemEfficiency' => 0.85
        ],
        [
            'id' => 'dah-330',
            'name' => 'DAH',
            'power' => 0.330,
            'type' => 'POLI',
            'category' => 'panel',
            'utilArea' => 1.938,
            'panelEfficiency' => 0.17,
            'systemEfficiency' => 0.86
        ],
        [
            'id' => 'byd',
            'name' => 'BYD',
            'power' => 0.400,
            'type' => 'MONO',
            'category' => 'panel',
            'utilArea' => 1.7974,
            'panelEfficiency' => 0.19,
            'systemEfficiency' => 0.85
        ],
        [
            'id' => 'jinko',
            'name' => 'JINKO',
            'power' => 0.530,
            'type' => 'MONO',
            'category' => 'panel',
            'utilArea' => 1.7974,
            'panelEfficiency' => 0.199,
            'systemEfficiency' => 0.85
        ],
        [
            'id' => 'phono',
            'name' => 'PHONO',
            'power' => 0.535,
            'type' => 'MONO',
            'category' => 'panel',
            'utilArea' => 1.7974,
            'panelEfficiency' => 0.207,
            'systemEfficiency' => 0.85
        ],
    ],
];
