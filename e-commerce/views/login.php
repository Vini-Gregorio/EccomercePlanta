<?php session_start();
$error = $_SESSION['auth_error'] ?? null;
$debug = $_SESSION['auth_debug'] ?? null;
unset($_SESSION['auth_error'], $_SESSION['auth_debug']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Flo</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body { background: #fff; font-family: Arial, Helvetica, sans-serif; }
    .login-wrap { max-width:1000px; margin:40px auto; padding:30px; }
    .login-card { background:#1f5d33; color:#fff; border-radius:28px; display:flex; overflow:hidden; }
    .login-left { flex:1; background:linear-gradient(#eaf6ea, #eaf6ea); display:flex; align-items:center; justify-content:center; }
    .login-left img{ max-width:90%; height:auto }
    .login-right { flex:1; padding:50px; }
    .login-right h1{ font-size:48px; margin:0 0 20px 0; color:#fff }
    .login-right label{ display:block; color:#dfeede; margin-top:12px }
    .login-right input[type="email"], .login-right input[type="password"]{ width:100%; padding:12px; border-radius:20px; border:none; margin-top:8px }
    .login-right .btn { margin-top:18px; background:#fff; color:#1f5d33; padding:10px 20px; border-radius:20px; border:none; cursor:pointer }
    .login-right .links{ margin-top:12px; font-size:14px }
    .error { background:#ffdddd; color:#900; padding:10px; border-radius:6px; margin-bottom:10px }
    @media (max-width:800px){ .login-card{ flex-direction:column } .login-left, .login-right{ padding:20px } }
  </style>
</head>
<body>
  <div class="login-wrap">
    <div class="login-card">
      <div class="login-left">
        <img src="../imgs/plantaApresentacao.png" alt="planta">
      </div>
      <div class="login-right">
        <h1>Login</h1>
        <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <?php if ($debug): ?>
          <div style="background:#fff;color:#000;padding:8px;border-radius:6px;margin-bottom:8px;font-size:13px">
            <strong>Debug:</strong>
            <div>user_found: <?= $debug['user_found'] ? 'yes' : 'no' ?></div>
            <?php if (isset($debug['db_len'])): ?>
              <div>db_len: <?= htmlspecialchars($debug['db_len']) ?></div>
              <div>db_preview: <?= htmlspecialchars($debug['db_preview']) ?></div>
              <div>password_verify: <?= $debug['password_verify'] ? 'true' : 'false' ?></div>
              <div>direct_equal: <?= $debug['direct_equal'] ? 'true' : 'false' ?></div>
            <?php endif; ?>
          </div>
        <?php endif; ?>
        <form method="POST" action="../controllers/auth.php">
          <label for="email">E-mail:</label>
          <input id="email" name="email" type="email" required>
          <label for="password">Senha:</label>
          <input id="password" name="password" type="password" required>
          <input type="hidden" name="return" value="<?= htmlspecialchars($_GET['return'] ?? 'index.php') ?>">
          <button class="btn" type="submit">Entrar</button>
        </form>
        <div class="links">
          <a href="cadastro.php" style="color:#dfeede">Cadastrar</a> |
          <a href="#" style="color:#dfeede">Recuperar</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
