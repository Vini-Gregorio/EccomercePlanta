<?php
session_start();
require_once __DIR__ . '/../config/database.php';

$email = trim($_POST['email'] ?? '');
$pass = trim($_POST['password'] ?? '');
$return = $_POST['return'] ?? 'index.php';

if (!$email || !$pass) {
    $_SESSION['auth_error'] = 'E-mail e senha são obrigatórios.';
    header('Location: ../views/login.php');
    exit;
}

$pdo = Database::connect();
$stmt = $pdo->prepare('SELECT id, email, senha FROM usuarios WHERE email = ? LIMIT 1');
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['auth_error'] = 'Usuário não encontrado.';
    header('Location: ../views/login.php');
    exit;
}


if (isset($user['senha'])) {
    $dbSenha = trim($user['senha']);
    // prefer hashed verification
    if (@password_verify($pass, $dbSenha)) {
        $ok = true;
    } elseif ($pass === $dbSenha) {
        $ok = true;
    }
}

if (!$ok) {
    $debug = [];
    $debug['user_found'] = (bool)$user;
    if ($user && isset($user['senha'])) {
        $dbSenha = trim($user['senha']);
        $debug['db_len'] = strlen($dbSenha);
        $debug['db_preview'] = substr($dbSenha, 0, 6) . '...' . substr($dbSenha, -4);
        $debug['password_verify'] = @password_verify($pass, $dbSenha) ? true : false;
        $debug['direct_equal'] = ($pass === $dbSenha) ? true : false;
    }
    $_SESSION['auth_error'] = 'Senha inválida.';
    $_SESSION['auth_debug'] = $debug;
    header('Location: ../views/login.php');
    exit;
}

session_regenerate_id(true);
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_email'] = $user['email'] ?? null;
header('Location: ../views/' . ltrim($return, '/'));
exit;
