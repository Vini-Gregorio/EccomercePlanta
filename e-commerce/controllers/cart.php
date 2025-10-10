<?php
session_start();
require_once __DIR__ . '/../model/planta.php';

$action = $_POST['action'] ?? '';
$productId = $_POST['product_id'] ?? null;
$qty = max(1, (int)($_POST['quantity'] ?? 1));
$return = $_POST['return'] ?? ($_SERVER['HTTP_REFERER'] ?? '/');

if (!$productId) {
    header('Location: ' . $return);
    exit;
}

// initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($action === 'add') {
    $prod = Planta::buscarPorId($productId);
    if ($prod) {
        if (!isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] = ['product' => $prod, 'quantity' => 0];
        }
        $_SESSION['cart'][$productId]['quantity'] += $qty;
    }
} elseif ($action === 'remove') {
    unset($_SESSION['cart'][$productId]);
}

header('Location: ' . $return);
exit;
