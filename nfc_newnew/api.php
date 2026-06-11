<?php
/**
 * api.php
 * Central API endpoint used by index.php, signup.php, customer-login.php,
 * login.php, staff.php and admin/indexadmin.php.
 *
 * Every action reads/writes the SAME database (nfc_restaurant) so that
 * customer orders, staff updates and admin changes are always in sync.
 *
 * Usage: POST/GET to api.php with `action=...` plus the required fields.
 * Always returns JSON: { success: bool, message: string, ...data }
 */

session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/includes/db.php';

function out($arr) {
    echo json_encode($arr);
    exit;
}

if (!$pdo) {
    out(['success' => false, 'message' => 'Database connection failed: ' . ($db_error ?? 'unknown error')]);
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

/* ----------------------------------------------------------------
   Helpers
------------------------------------------------------------------*/
function requireStaff($pdo) {
    if (empty($_SESSION['staff_id'])) {
        out(['success' => false, 'message' => 'Not logged in as staff/admin.']);
    }
}
function requireAdmin($pdo) {
    if (empty($_SESSION['staff_id']) || ($_SESSION['staff_role'] ?? '') !== 'admin') {
        out(['success' => false, 'message' => 'Admin access only.']);
    }
}

switch ($action) {

/* ============================================================
   AUTH — CUSTOMER
============================================================ */
case 'customer_register': {
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if (!$name || !$email || !$pass) out(['success'=>false,'message'=>'Please fill in all required fields.']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) out(['success'=>false,'message'=>'Invalid email address.']);
    if (strlen($pass) < 8) out(['success'=>false,'message'=>'Password must be at least 8 characters.']);

    $stmt = $pdo->prepare('SELECT customer_id FROM customer WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) out(['success'=>false,'message'=>'An account with this email already exists.']);

    $hash = password_hash($pass, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare('INSERT INTO customer (name, email, phone, password) VALUES (?, ?, ?, ?)');
    $stmt->execute([$name, $email, $phone, $hash]);
    $custId = $pdo->lastInsertId();

    $_SESSION['customer_id']   = $custId;
    $_SESSION['customer_name'] = $name;

    out(['success'=>true,'message'=>'Account created.','customer_id'=>$custId,'name'=>$name]);
}

case 'customer_login': {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';
    if (!$email || !$pass) out(['success'=>false,'message'=>'Please enter email and password.']);

    $stmt = $pdo->prepare('SELECT customer_id, name, password FROM customer WHERE email = ?');
    $stmt->execute([$email]);
    $row = $stmt->fetch();

    if (!$row || !password_verify($pass, $row['password'])) {
        out(['success'=>false,'message'=>'Invalid email or password.']);
    }

    $_SESSION['customer_id']   = $row['customer_id'];
    $_SESSION['customer_name'] = $row['name'];
    out(['success'=>true,'message'=>'Logged in.','customer_id'=>$row['customer_id'],'name'=>$row['name']]);
}

case 'customer_session': {
    if (!empty($_SESSION['customer_id'])) {
        out(['success'=>true,'logged_in'=>true,'customer_id'=>$_SESSION['customer_id'],'name'=>$_SESSION['customer_name']]);
    }
    out(['success'=>true,'logged_in'=>false]);
}

/* ============================================================
   AUTH — STAFF / ADMIN
============================================================ */
case 'staff_login': {
    $username = trim($_POST['username'] ?? '');
    $pass     = $_POST['password'] ?? '';
    $roleWanted = $_POST['role'] ?? '';

    if (!$username || !$pass) out(['success'=>false,'message'=>'Please enter username and password.']);

    $stmt = $pdo->prepare('SELECT staff_id, username, password, full_name, role FROM staff WHERE username = ?');
    $stmt->execute([$username]);
    $row = $stmt->fetch();

    if (!$row) out(['success'=>false,'message'=>'Invalid username or password.']);

    // Support both plain-text seeded passwords and bcrypt hashes
    $valid = ($row['password'] === $pass) || password_verify($pass, $row['password']);
    if (!$valid) out(['success'=>false,'message'=>'Invalid username or password.']);

    if ($roleWanted && $roleWanted !== $row['role']) {
        out(['success'=>false,'message'=>'Invalid role selected for this account.']);
    }

    $_SESSION['staff_id']   = $row['staff_id'];
    $_SESSION['staff_user'] = $row['username'];
    $_SESSION['staff_name'] = $row['full_name'];
    $_SESSION['staff_role'] = $row['role'];

    out(['success'=>true,'message'=>'Logged in.','role'=>$row['role'],'name'=>$row['full_name']]);
}

case 'staff_session': {
    if (!empty($_SESSION['staff_id'])) {
        out(['success'=>true,'logged_in'=>true,'role'=>$_SESSION['staff_role'],'name'=>$_SESSION['staff_name']]);
    }
    out(['success'=>true,'logged_in'=>false]);
}

case 'logout': {
    $_SESSION = [];
    session_destroy();
    out(['success'=>true]);
}

/* ============================================================
   MENU (public read; admin write)
============================================================ */
case 'menu_list': {
    // Public: only available items, used by customer-facing pages
    $stmt = $pdo->query("SELECT m.*, c.category_name FROM menu m
                          LEFT JOIN menu_category c ON m.category_id = c.category_id
                          WHERE m.is_available = 1
                          ORDER BY c.display_order, m.menu_id");
    out(['success'=>true,'items'=>$stmt->fetchAll()]);
}

case 'menu_list_all': {
    requireStaff($pdo);
    $stmt = $pdo->query("SELECT m.*, c.category_name FROM menu m
                          LEFT JOIN menu_category c ON m.category_id = c.category_id
                          ORDER BY c.display_order, m.menu_id");
    out(['success'=>true,'items'=>$stmt->fetchAll()]);
}

case 'menu_toggle': {
    requireAdmin($pdo);
    $id = (int)($_POST['menu_id'] ?? 0);
    $stmt = $pdo->prepare('UPDATE menu SET is_available = 1 - is_available WHERE menu_id = ?');
    $stmt->execute([$id]);
    out(['success'=>true,'message'=>'Item availability updated.']);
}

/* ============================================================
   CATEGORIES
============================================================ */
case 'categories_list': {
    $stmt = $pdo->query("SELECT c.*, (SELECT COUNT(*) FROM menu m WHERE m.category_id = c.category_id) AS item_count
                          FROM menu_category c ORDER BY c.display_order, c.category_id");
    out(['success'=>true,'categories'=>$stmt->fetchAll()]);
}

case 'category_add': {
    requireAdmin($pdo);
    $name = trim($_POST['name'] ?? '');
    if (!$name) out(['success'=>false,'message'=>'Enter a category name.']);

    $stmt = $pdo->prepare('SELECT category_id FROM menu_category WHERE category_name = ?');
    $stmt->execute([$name]);
    if ($stmt->fetch()) out(['success'=>false,'message'=>'Category already exists.']);

    $stmt = $pdo->query('SELECT COALESCE(MAX(display_order),0)+1 AS nxt FROM menu_category');
    $nxt = $stmt->fetch()['nxt'];

    $stmt = $pdo->prepare('INSERT INTO menu_category (category_name, display_order) VALUES (?, ?)');
    $stmt->execute([$name, $nxt]);
    out(['success'=>true,'message'=>'Category added.']);
}

case 'category_delete': {
    requireAdmin($pdo);
    $id = (int)($_POST['category_id'] ?? 0);
    $stmt = $pdo->prepare('SELECT COUNT(*) c FROM menu WHERE category_id = ?');
    $stmt->execute([$id]);
    if ($stmt->fetch()['c'] > 0) out(['success'=>false,'message'=>'Remove items from this category first.']);

    $stmt = $pdo->prepare('DELETE FROM menu_category WHERE category_id = ?');
    $stmt->execute([$id]);
    out(['success'=>true,'message'=>'Category deleted.']);
}

/* ============================================================
   ORDERS
============================================================ */
case 'place_order': {
    if (empty($_SESSION['customer_id'])) {
        out(['success'=>false,'message'=>'Please log in to place an order.']);
    }
    $custId   = $_SESSION['customer_id'];
    $cartJson = $_POST['cart'] ?? '[]';
    $cart     = json_decode($cartJson, true);
    if (!is_array($cart) || count($cart) === 0) {
        out(['success'=>false,'message'=>'Your cart is empty.']);
    }

    $total = 0;
    foreach ($cart as $item) {
        $total += (float)($item['priceNum'] ?? 0) * (int)($item['qty'] ?? 1);
    }

    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare('INSERT INTO orders (customer_id, total_price, order_status) VALUES (?, ?, \'pending\')');
        $stmt->execute([$custId, round($total, 2)]);
        $orderId = $pdo->lastInsertId();

        $stmt = $pdo->prepare('INSERT INTO order_details (order_id, menu_id, item_name, quantity, unit_price, subtotal) VALUES (?, ?, ?, ?, ?, ?)');
        foreach ($cart as $item) {
            $menuId = isset($item['id']) ? (int)$item['id'] : null;
            $qty    = (int)($item['qty'] ?? 1);
            $price  = (float)($item['priceNum'] ?? 0);
            $stmt->execute([$orderId, $menuId ?: null, $item['title'] ?? 'Unknown', $qty, $price, round($price*$qty,2)]);
        }
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        out(['success'=>false,'message'=>'Could not place order: '.$e->getMessage()]);
    }

    out(['success'=>true,'message'=>'Order placed successfully.','order_id'=>$orderId,'total'=>round($total,2)]);
}

case 'orders_list': {
    requireStaff($pdo);
    $stmt = $pdo->query("SELECT o.order_id, o.total_price, o.order_status, o.order_date,
                                 c.name AS customer_name
                          FROM orders o
                          LEFT JOIN customer c ON o.customer_id = c.customer_id
                          ORDER BY o.order_date DESC");
    $orders = $stmt->fetchAll();

    // attach items
    $itemStmt = $pdo->prepare('SELECT item_name, quantity, unit_price, subtotal FROM order_details WHERE order_id = ?');
    foreach ($orders as &$o) {
        $itemStmt->execute([$o['order_id']]);
        $o['items'] = $itemStmt->fetchAll();
    }
    out(['success'=>true,'orders'=>$orders]);
}

case 'order_update_status': {
    requireStaff($pdo);
    $id     = (int)($_POST['order_id'] ?? 0);
    $status = $_POST['status'] ?? '';
    $valid  = ['pending','preparing','ready','completed','cancelled'];
    if (!in_array($status, $valid)) out(['success'=>false,'message'=>'Invalid status.']);

    $stmt = $pdo->prepare('UPDATE orders SET order_status = ? WHERE order_id = ?');
    $stmt->execute([$status, $id]);
    out(['success'=>true,'message'=>'Order status updated.']);
}

/* ============================================================
   CUSTOMERS (admin)
============================================================ */
case 'customers_list': {
    requireStaff($pdo);
    $stmt = $pdo->query("SELECT c.customer_id, c.name, c.email, c.phone, c.created_at,
                                 (SELECT COUNT(*) FROM orders o WHERE o.customer_id = c.customer_id) AS order_count
                          FROM customer c ORDER BY c.customer_id DESC");
    out(['success'=>true,'customers'=>$stmt->fetchAll()]);
}

case 'customer_add': {
    requireAdmin($pdo);
    $name  = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $pass  = $_POST['password'] ?? '';
    if (!$name || !$email) out(['success'=>false,'message'=>'Please fill required fields.']);
    if (!$pass) $pass = 'changeme123';

    $stmt = $pdo->prepare('SELECT customer_id FROM customer WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) out(['success'=>false,'message'=>'Email already registered.']);

    $hash = password_hash($pass, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare('INSERT INTO customer (name, email, phone, password) VALUES (?, ?, ?, ?)');
    $stmt->execute([$name, $email, $phone, $hash]);
    out(['success'=>true,'message'=>'Customer added.']);
}

case 'customer_delete': {
    requireAdmin($pdo);
    $id = (int)($_POST['customer_id'] ?? 0);
    // Orders reference customer via FK; null them out instead of blocking delete
    $pdo->prepare('UPDATE orders SET customer_id = NULL WHERE customer_id = ?')->execute([$id]);
    $pdo->prepare('DELETE FROM customer WHERE customer_id = ?')->execute([$id]);
    out(['success'=>true,'message'=>'Customer deleted.']);
}

/* ============================================================
   STAFF (admin)
============================================================ */
case 'staff_list': {
    requireAdmin($pdo);
    $stmt = $pdo->query('SELECT staff_id, username, full_name, email, role FROM staff ORDER BY staff_id');
    out(['success'=>true,'staff'=>$stmt->fetchAll()]);
}

case 'staff_add': {
    requireAdmin($pdo);
    $username = trim($_POST['username'] ?? '');
    $name     = trim($_POST['full_name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $pass     = $_POST['password'] ?? '';
    $role     = $_POST['role'] ?? 'staff';
    if (!$username || !$name) out(['success'=>false,'message'=>'Please fill required fields.']);
    if (!$pass) $pass = 'staff123';
    if (!in_array($role, ['admin','staff'])) $role = 'staff';

    $stmt = $pdo->prepare('SELECT staff_id FROM staff WHERE username = ?');
    $stmt->execute([$username]);
    if ($stmt->fetch()) out(['success'=>false,'message'=>'Username already exists.']);

    $hash = password_hash($pass, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare('INSERT INTO staff (username, password, full_name, email, role) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$username, $hash, $name, $email, $role]);
    out(['success'=>true,'message'=>'Staff account added.']);
}

case 'staff_delete': {
    requireAdmin($pdo);
    $id = (int)($_POST['staff_id'] ?? 0);
    $stmt = $pdo->prepare('SELECT username FROM staff WHERE staff_id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if ($row && $row['username'] === 'admin') out(['success'=>false,'message'=>'Cannot delete the main admin account.']);

    $pdo->prepare('DELETE FROM staff WHERE staff_id = ?')->execute([$id]);
    out(['success'=>true,'message'=>'Staff account deleted.']);
}

/* ============================================================
   SYSTEM INFO (admin)
============================================================ */
case 'sysinfo_list': {
    $stmt = $pdo->query('SELECT info_key, info_value FROM system_info');
    $rows = $stmt->fetchAll();
    $info = [];
    foreach ($rows as $r) $info[$r['info_key']] = $r['info_value'];
    out(['success'=>true,'info'=>$info]);
}

case 'sysinfo_update': {
    requireAdmin($pdo);
    $key = $_POST['key'] ?? '';
    $val = $_POST['value'] ?? '';
    $stmt = $pdo->prepare('UPDATE system_info SET info_value = ? WHERE info_key = ?');
    $stmt->execute([$val, $key]);
    out(['success'=>true,'message'=>'Setting updated.']);
}

/* ============================================================
   DASHBOARD (admin)
============================================================ */
case 'dashboard_stats': {
    requireStaff($pdo);
    $stats = [];
    $stats['total_orders'] = (int)$pdo->query('SELECT COUNT(*) c FROM orders')->fetch()['c'];
    $stats['pending']      = (int)$pdo->query("SELECT COUNT(*) c FROM orders WHERE order_status IN ('pending','preparing')")->fetch()['c'];
    $stats['revenue_today']= (float)$pdo->query("SELECT COALESCE(SUM(total_price),0) r FROM orders WHERE order_status='completed' AND DATE(order_date)=CURDATE()")->fetch()['r'];
    $stats['customers']    = (int)$pdo->query('SELECT COUNT(*) c FROM customer')->fetch()['c'];
    $stats['menu_items']   = (int)$pdo->query('SELECT COUNT(*) c FROM menu')->fetch()['c'];
    out(['success'=>true,'stats'=>$stats]);
}

default:
    out(['success'=>false,'message'=>'Unknown action.']);
}
