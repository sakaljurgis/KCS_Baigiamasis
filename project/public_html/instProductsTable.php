<?php

header("content-type: text/text");

$dbh = new PDO("mysql:host=db_1;dbname=kcs_db", 'devuser', 'devpass');
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$createTable = 'create table products
(
    id int NOT NULL auto_increment,
    name varchar(255) null,
    description varchar(255) null,
    sku varchar(64) null,
    price decimal(11,4) not null,
    quantity int(10) null,
    created_at datetime DEFAULT CURRENT_TIMESTAMP,
    updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);';


$dbh->exec($createTable);


/*
$insertData = [
    [
        'name' => 'Vardenis',
        'email' => 'vardenis@test.com',
        'phone' => '+37067777777',
    ],
    [
        'name' => 'Jonas',
        'email' => 'JOnas@test.com',
        'phone' => '+37067777778',
    ],
];
foreach ($insertData as $item) {
    $query = 'INSERT INTO visitors (name, email, phone) VALUES (:name, :email, :phone);';

    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':name', $item['name']);
    $stmt->bindParam(':email', $item['email']);
    $stmt->bindParam(':phone', $item['phone']);
    $stmt->execute();

}
*/