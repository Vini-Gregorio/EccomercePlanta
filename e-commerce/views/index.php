<?php
session_start();
if (empty($_SESSION['user_id'])) {
  // redirect anonymous users to login and return here after auth
  header('Location: login.php?return=index.php');
  exit;
}
require_once __DIR__ . '/../model/planta.php';
$produtos = Planta::listarTodos();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flo</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="cadastroproduto.css">
  <link rel="stylesheet" href="product_card.css">
  <style>
    .home-container { max-width:1100px; margin:30px auto; padding:20px; }
    .home-header { display:flex; justify-content:space-between; align-items:center; }
    .main-header-spacer { margin-bottom:20px; }
  </style>
</head>
<body>
  <header id="main-header" class="large-header">
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
        </nav>
    </div>
    <div class="header-content-main">
        <div class="main-text">
            <h1>Verde que<br> transforma seu<br> espaço.</h1>
        </div>
        <div class="main-image">
            <img src="../imgs/plantaApresentacao.png" alt="Calathea Zebrina em vaso branco"> </div>
    </div>
  </header>

  <main class="home-container" style="padding-top:600px;">
    <div class="home-header main-header-spacer">
      <h1>Produtos</h1>
      <a class="create-btn" href="cadastroproduto.php">+ Novo Produto</a>
    </div>

    <?php if (empty($produtos)): ?>
      <div class="no-results">Nenhum produto cadastrado.</div>
    <?php else: ?>
      <div class="product-grid">
        <?php foreach ($produtos as $p): ?>
          <?php $product = $p; $showButtonText = 'Visualizar'; include __DIR__ . '/components/product_card.php'; ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    </div>
  </main>

  <script src="script.js"></script>
</body>
</html>
