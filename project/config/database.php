<?php

return [
    'host' => $_SERVER['DB_HOST'] ?? 'localhost',
    'user' => $_SERVER['DB_USER'] ?? 'devuser',
    'password' => $_SERVER['DB_PASSWORD'] ?? '',
    'database' => $_SERVER['DB_NAME'] ?? 'kcs_db',
];