<?php

return [

    'hosts' => [
        env('ELASTICSEARCH_HOST', 'https://localhost:9200'),
    ],

    'api_key' => env('ELASTICSEARCH_TOKEN'),

    'login' => env('ELASTICSEARCH_LOGIN'),
    'password'=> env('ELASTICSEARCH_PASSWORD'),

    'sslVerification' => false,
];
