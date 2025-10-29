<?php
session_start();
require_once __DIR__ . '/../model/carrinho.php';
require_once __DIR__ . '/../model/planta.php';

$action = $_POST['action'] ?? '';
$productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : null;
$qty = max(0, (int)($_POST['quantity'] ?? 1));
$return = $_POST['return'] ?? ($_SERVER['HTTP_REFERER'] ?? '/');

if (empty($_SESSION['user_id'])) {
    $_SESSION['auth_error'] = 'Você precisa estar logado para gerenciar o carrinho.';
    header('Location: ../views/login.php');
    exit;
}

$userId = (int)$_SESSION['user_id'];

if (!$productId) {
    header('Location: ' . $return);
    exit;
}

$prod = Planta::buscarPorId($productId);
if (!$prod) {
    header('Location: ' . $return);
    exit;
}

if ($action === 'add') {
    Carrinho::addItem($userId, $productId, max(1, $qty));
} elseif ($action === 'update') {
    Carrinho::updateItem($userId, $productId, $qty);
} elseif ($action === 'remove') {
    Carrinho::removeItem($userId, $productId);
}

header('Location: ' . $return);
exit;
