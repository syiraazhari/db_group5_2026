<?php
/**
 * process_order.php
 * Receives signup + cart data from signup.php, creates the customer
 * account in the `customer` table, logs them in (PHP session), and
 * places their order into `orders` / `order_details`.
 *
 * Uses the SAME database (nfc_restaurant) as the rest of the site, so
 * the new order is immediately visible to staff.php and admin/indexadmin.php.
 */

session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/includes/db.php';

function jsonOut($success, $message = '', $extra = []) {
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $extra));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonOut(false, 'Invalid request method.');
}

if (!$pdo) {
    jsonOut(false, 'Database connection failed: ' . ($db_error ?? 'unknown error'));
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

/* ---- Check for duplicate email ---- */
$stmt = $pdo->prepare('SELECT customer_id FROM customer WHERE email = ?');
$stmt->execute([$email]);
if ($stmt->fetch()) {
    jsonOut(false, 'An account with this email already exists. Please sign in instead.');
}

/* ---- Hash password & insert customer ---- */
$hash = password_hash($password, PASSWORD_BCRYPT);
$stmt = $pdo->prepare('INSERT INTO customer (name, email, phone, password) VALUES (?, ?, ?, ?)');
$stmt->execute([$fullname, $email, $phone, $hash]);
$customerId = $pdo->lastInsertId();

/* ---- Log the new customer in ---- */
$_SESSION['customer_id']   = $customerId;
$_SESSION['customer_name'] = $fullname;

/* ---- Calculate order total ---- */
$total = 0;
foreach ($cart as $item) {
    $total += (float)($item['priceNum'] ?? 0) * (int)($item['qty'] ?? 1);
}

if (!empty($cart)) {
    $pdo->beginTransaction();
    try {
        /* ---- Insert order ---- */
        $stmt = $pdo->prepare("INSERT INTO orders (customer_id, total_price, order_status) VALUES (?, ?, 'pending')");
        $stmt->execute([$customerId, round($total, 2)]);
        $orderId = $pdo->lastInsertId();

        /* ---- Insert order items ---- */
        $stmt = $pdo->prepare('INSERT INTO order_details (order_id, menu_id, item_name, quantity, unit_price, subtotal) VALUES (?, ?, ?, ?, ?, ?)');
        foreach ($cart as $item) {
            $menuId = isset($item['id']) && $item['id'] !== '' ? (int)$item['id'] : null;
            $qty    = (int)($item['qty'] ?? 1);
            $price  = (float)($item['priceNum'] ?? 0);
            $stmt->execute([$orderId, $menuId, $item['title'] ?? 'Unknown', $qty, $price, round($price * $qty, 2)]);
        }
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        jsonOut(false, 'Account created, but order could not be saved: ' . $e->getMessage(), ['account_created' => true]);
    }
}

jsonOut(true, 'Account created and order placed successfully.', ['customer_id' => $customerId]);
