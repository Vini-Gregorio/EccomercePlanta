<?php session_start();
$error = $_SESSION['register_error'] ?? null;
$success = $_SESSION['register_success'] ?? null;
unset($_SESSION['register_error'], $_SESSION['register_success']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cadastro - Flo</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .card { background:#1f5d33; color:#fff; border-radius:26px; display:flex; overflow:hidden; max-width:1100px; margin:40px auto }
    .card-left{ flex:1; padding:40px }
    .card-right{ flex:1; background:#eaf6ea; display:flex; align-items:center; justify-content:center }
    .card-right img{ max-width:80% }
    label{ display:block; color:#dfeede; margin-top:12px }
    input{ width:100%; padding:10px; border-radius:18px; border:none; margin-top:8px }
    .btn{ background:#fff; color:#1f5d33; padding:10px 18px; border-radius:18px; border:none; margin-top:12px }
    .error{ background:#ffdddd; color:#900; padding:8px; border-radius:6px }
    .success{ background:#ddffea; color:#084; padding:8px; border-radius:6px }
  </style>
</head>
<body>
  <div class="card">
    <div class="card-left">
      <h1>Cadastro</h1>
  <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <?php if ($success): ?><div class="success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
  <div style="background:#fff3cd;color:#856404;padding:8px;border-radius:6px;margin-bottom:8px">Aviso: por simplicidade temporária a senha será armazenada em texto simples. Atualize isso depois para usar hashes.</div>
      <form method="POST" action="../controllers/register.php">
        <label>E-mail</label>
        <input type="email" name="email" required>
        <label>Senha</label>
        <input type="password" name="password" required>
        <label>Confirmar senha</label>
        <input type="password" name="password_confirm" required>
        <button class="btn" type="submit">Cadastrar</button>
      </form>
    </div>
    <div class="card-right">
      <img src="../imgs/plantaApresentacao.png" alt="planta">
    </div>
  </div>
</body>
</html>
