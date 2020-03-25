<?php

$config = require_once 'config.php';

try {
    $db = new PDO("mysql: host = {$config['host']};dbname={$config['database']};charset=UTF8",
        $config['user'], $config['password'],
        [PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    $db->exec("set names utf8");
} catch (Exception $error) {

    exit('Database error');

}