<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$email = $_POST['email'] ?? '';
$pass = $_POST['password'] ?? '';
$pass2 = $_POST['password_confirm'] ?? '';

if (!$email || !$pass) {
    $_SESSION['register_error'] = 'E-mail e senha são obrigatórios.';
    header('Location: ../views/cadastro.php');
    exit;
}
if ($pass !== $pass2) {
    $_SESSION['register_error'] = 'As senhas não coincidem.';
    header('Location: ../views/cadastro.php');
    exit;
}
$pdo = Database::connect();
// check existing
$st = $pdo->prepare('SELECT id FROM usuarios WHERE email = ? LIMIT 1');
$st->execute([$email]);
if ($st->fetch()) {
    $_SESSION['register_error'] = 'E-mail já cadastrado.';
    header('Location: ../views/cadastro.php');
    exit;
}
$passToStore = $pass; 
$ins = $pdo->prepare('INSERT INTO usuarios (email, senha) VALUES (?, ?)');
$ins->execute([$email, $passToStore]);
$_SESSION['register_success'] = 'Cadastro realizado. Faça login.';
header('Location: ../views/login.php');
exit;
