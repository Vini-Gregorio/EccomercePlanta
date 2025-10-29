<?php
session_start();
$userEmail = $_SESSION['user_email'] ?? null;
// fallback to DB lookup only if session doesn't have the email
if (!$userEmail && !empty($_SESSION['user_id'])) {
    require_once __DIR__ . '/../config/database.php';
    try {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('SELECT email FROM usuarios WHERE id = ? LIMIT 1');
        $stmt->execute([ (int)$_SESSION['user_id'] ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) $userEmail = $row['email'] ?? null;
    } catch (Exception $e) {
        $userEmail = null;
    }
}
?>
<header class="small-header">
  <div class="header-content-top">
        <div class="logo">
            <img src="../imgs/icon.png" alt="Flo Logo"> </div>
        <div class="search-container">
            <input type="text" placeholder="Buscar..." aria-label="Search">
            <button class="search-icon" aria-label="Search button"></button>
        </div>
        <nav class="header-nav">
            <a href="#history" class="history-link">Histórico</a>
            <a href="cart.php" class="cart-icon" aria-label="Shopping Cart">
                <img src="../imgs/carrinho.png" alt="Carrinho">
            </a>
            <?php if ($userEmail): ?>
              <span style="margin-left:12px;color:#2b6;">Olá, <?= htmlspecialchars($userEmail) ?></span>
              <a href="../controllers/logout.php" style="margin-left:8px;color:#d33;">Sair</a>
            <?php else: ?>
              <a href="login.php" style="margin-left:12px">Entrar</a>
              <a href="cadastro.php" style="margin-left:8px">Cadastrar</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
