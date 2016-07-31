<?php
$root = realpath(__DIR__.'/../../');

return array(
    'default' => array(
        'driver' => 'pdo',
        'connection' => 'mysql:host=localhost;dbname=suspensk',
        'user'     => 'root',
        'password' => '1'
    )
);