<?php
/**
 * includes/db.php
 * Shared PDO database connection for the whole site.
 * All pages/scripts (index.php, signup.php, login.php, staff.php,
 * admin/indexadmin.php, api.php, process_order.php) include this file
 * so they all talk to the SAME database: nfc_restaurant
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');   // change to your MySQL username
define('DB_PASS', '');       // change to your MySQL password
define('DB_NAME', 'nfc_restaurant');

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    // Used by api.php (returns JSON) and pages (can check $pdo === null)
    $pdo = null;
    $db_error = $e->getMessage();
}
