<?php
return [
    [
        'method' => 'POST',
        'action' => 'store',
        'resource' => 'match',
        'controller-file' => 'match',
        'callback' => '\Controllers\Match\store'
    ],
    [
        'method' => 'POST',
        'action' => 'store',
        'resource' => 'team',
        'controller-file' => 'team',
        'callback' => '\Controllers\Team\store'
    ],
    [
        'method' => 'GET',
        'action' => '',
        'resource' => '',
        'controller-file' => 'page',
        'callback' => '\Controllers\Page\dashboard'
    ]
];