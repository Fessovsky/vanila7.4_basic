<?php
return [
    'GET' => [
        '/' => [
            'controller' => 'Components\Controllers\HomeController',
            'action' => 'index'
        ],
        '/upload' => [
            'controller' => 'Components\Controllers\UploadController',
            'action' => 'index'
        ],
    ],
    'POST' => [
        '/upload' => [
            'controller' => 'Components\Controllers\UploadController',
            'action' => 'upload'
        ]
    ],
];