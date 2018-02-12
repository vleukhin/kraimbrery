<?php

$config = [
    'displayErrorDetails'    => getenv('APP_DEBUG'),
    'addContentLengthHeader' => false,

    'db' => [
        'driver'    => 'mysql',
        'host'      => getenv('DB_HOST'),
        'username'  => getenv('DB_USERNAME'),
        'password'  => getenv('DB_PASSWORD'),
        'database'  => getenv('DB_DATABASE'),
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ],
];

return $config;