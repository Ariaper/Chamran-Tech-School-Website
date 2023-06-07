<?php
define('DB_HOST', 'localhost');
define("DB_USER", "root");
define("DB_PASS", "");
define('DB_NAME', 'school_db');


$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
try {
    $db = new PDO($dsn, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $db;
} catch (PDOException $e) {
    print("error:" . $e->getMessage() . "<br>");
    exit();
}