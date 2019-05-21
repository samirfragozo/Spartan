<?php

return [

    'use' => 'production',
    'properties' => [
        'production' => [
            'host'                => env('RABBIT_HOST', 'localhost'),
            'port'                => env('RABBIT_PORT', 5672),
            'username'            => env('RABBIT_USERNAME', ''),
            'password'            => env('RABBIT_PASSWORD', ''),
            'vhost'               => '/',
            'exchange'            => 'amq.direct',
            'exchange_type'       => 'direct',
            'exchange_durable'    => true,
            'consumer_tag'        => 'consumer',
            'ssl_options'         => [], // See https://secure.php.net/manual/en/context.ssl.php
            'connect_options'     => [], // See https://github.com/php-amqplib/php-amqplib/blob/master/PhpAmqpLib/Connection/AMQPSSLConnection.php
            'queue_properties'    => ['x-ha-policy' => ['S', 'all']],
            'exchange_properties' => [],
            'timeout'             => 0
        ],
    ],

];