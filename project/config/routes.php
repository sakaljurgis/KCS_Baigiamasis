<?php

return [
    [
        'path' => '/visitors',
        'method' => 'get',
        'class' => \KCS\Controller\VisitorController::class,
        'action' => 'index',
    ],
    [
        'path' => '/visitors/{id}',
        'method' => 'get',
        'class' => \KCS\Controller\VisitorController::class,
        'action' => 'show',
    ],
    [
        'path' => '/visitors',
        'method' => 'post',
        'class' => \KCS\Controller\VisitorController::class,
        'action' => 'store',
    ],
];