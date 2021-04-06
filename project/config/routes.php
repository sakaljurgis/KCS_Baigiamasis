<?php

return [
    [
        'path' => '/products',
        'method' => 'get',
        'class' => \KCS\Controller\ProductController::class,
        'action' => 'index',
    ],
    [
        'path' => '/products/{id}',
        'method' => 'get',
        'class' => \KCS\Controller\ProductController::class,
        'action' => 'show',
    ],
    [
        'path' => '/products',
        'method' => 'post',
        'class' => \KCS\Controller\ProductController::class,
        'action' => 'store',
    ],
    [
        'path' => '/products',
        'method' => 'options', //todo - implement
        'class' => \KCS\Controller\ProductController::class,
        'action' => 'explain', //todo - return value available fields and types?
    ],
    [
        'path' => '/products/{id}',
        'method' => 'post',
        'class' => \KCS\Controller\ProductController::class,
        'action' => 'update',
    ],
    [
        'path' => '/products/{id}',
        'method' => 'delete',
        'class' => \KCS\Controller\ProductController::class,
        'action' => 'delete',
    ],
];