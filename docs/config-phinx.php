<?php
/**
 * Created by PhpStorm.
 * User: Sofia
 * Date: 15/1/2017
 * Time: 1:15 PM
 */
require 'config.php';

return [
    'paths' => [
        'migrations' => 'migrations'
    ],
    'migration_base_class' => '\App\Migration\Migration',
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'dev',
        'dev' => [
            'adapter' => 'mysql',
            'host' => DB_HOST,
            'name' => DB_NAME,
            'user' => DB_USER,
            'pass' => DB_PASSWORD,
            'port' => DB_PORT
        ]
    ]
];