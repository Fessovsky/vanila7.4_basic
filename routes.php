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
        '/notify' => [
            'controller' => 'Components\Controllers\NotifyController',
            'action' => 'index'
        ]
    ],
    'POST' => [
        '/upload' => [
            'controller' => 'Components\Controllers\UploadController',
            'action' => 'upload'
        ],
        '/notify' => [
            'controller' => 'Components\Controllers\NotifyController',
            'action' => 'notify'
        ],
    ],
];