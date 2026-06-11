<?php
/**
 * process_order.php
 * Receives signup + cart data, saves to MySQL via phpMyAdmin.
 *
 * DATABASE SETUP — run this SQL once in phpMyAdmin:
 *
 *   CREATE DATABASE IF NOT EXISTS nfc_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
 *   USE nfc_db;
 *
 *   CREATE TABLE users (
 *     id        INT AUTO_INCREMENT PRIMARY KEY,
 *     fullname  VARCHAR(150) NOT NULL,
 *     email     VARCHAR(191) NOT NULL UNIQUE,
 *     phone     VARCHAR(30),
 *     password  VARCHAR(255) NOT NULL,
 *     created_at DATETIME DEFAULT CURRENT_TIMESTAMP
 *   );
 *
 *   CREATE TABLE orders (
 *     id         INT AUTO_INCREMENT PRIMARY KEY,
 *     user_id    INT NOT NULL,
 *     total_rm   DECIMAL(8,2) NOT NULL,
 *     status     ENUM('pending','preparing','ready','done') DEFAULT 'pending',
 *     created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 *     FOREIGN KEY (user_id) REFERENCES users(id)
 *   );
 *
 *   CREATE TABLE order_items (
 *     id         INT AUTO_INCREMENT PRIMARY KEY,
 *     order_id   INT NOT NULL,
 *     item_title VARCHAR(200) NOT NULL,
 *     price      DECIMAL(8,2) NOT NULL,
 *     qty        INT NOT NULL,
 *     FOREIGN KEY (order_id) REFERENCES orders(id)
 *   );
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

/* ---- DB CONFIG — change these to match your phpMyAdmin setup ---- */
define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // your MySQL username
define('DB_PASS', '');           // your MySQL password
define('DB_NAME', 'nfc_db');

function jsonOut($success, $message = '') {
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonOut(false, 'Invalid request method.');
}

/* ---- Collect & sanitize inputs ---- */
$fullname = trim($_POST['fullname'] ?? '');
$email    = trim($_POST['email']    ?? '');
$phone    = trim($_POST['phone']    ?? '');
$password = $_POST['password']      ?? '';
$cartJson = $_POST['cart']          ?? '[]';

if (!$fullname || !$email || !$password) {
    jsonOut(false, 'Missing required fields.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonOut(false, 'Invalid email address.');
}
if (strlen($password) < 8) {
    jsonOut(false, 'Password too short.');
}

$cart = json_decode($cartJson, true);
if (!is_array($cart)) $cart = [];

/* ---- Connect to DB ---- */
$pdo = null;
try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    jsonOut(false, 'Database connection failed: ' . $e->getMessage());
}

/* ---- Check for duplicate email ---- */
$stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
$stmt->execute([$email]);
if ($stmt->fetch()) {
    jsonOut(false, 'An account with this email already exists.');
}

/* ---- Hash password & insert user ---- */
$hash = password_hash($password, PASSWORD_BCRYPT);
$stmt = $pdo->prepare('INSERT INTO users (fullname, email, phone, password) VALUES (?, ?, ?, ?)');
$stmt->execute([$fullname, $email, $phone, $hash]);
$userId = $pdo->lastInsertId();

/* ---- Calculate order total ---- */
$total = 0;
foreach ($cart as $item) {
    $total += (float)($item['priceNum'] ?? 0) * (int)($item['qty'] ?? 1);
}

/* ---- Insert order ---- */
$stmt = $pdo->prepare('INSERT INTO orders (user_id, total_rm) VALUES (?, ?)');
$stmt->execute([$userId, round($total, 2)]);
$orderId = $pdo->lastInsertId();

/* ---- Insert order items ---- */
if (!empty($cart)) {
    $stmt = $pdo->prepare('INSERT INTO order_items (order_id, item_title, price, qty) VALUES (?, ?, ?, ?)');
    foreach ($cart as $item) {
        $stmt->execute([
            $orderId,
            $item['title']    ?? 'Unknown',
            (float)($item['priceNum'] ?? 0),
            (int)($item['qty'] ?? 1),
        ]);
    }
}

jsonOut(true, 'Order placed successfully.');
?>
