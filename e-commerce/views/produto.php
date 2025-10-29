<?php
require_once __DIR__ . '/../config/require_login.php';
require_once __DIR__ . '/../model/planta.php';
$id = $_GET['id'] ?? null;
$produto = null;
if ($id) {
    $produto = Planta::buscarPorId($id);
}
if (!$produto) {
    // simple fallback
    header('HTTP/1.1 404 Not Found');
    echo '<h1>Produto não encontrado</h1>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($produto['nome']) ?></title>
  <link rel="stylesheet" href="cadastroproduto.css">
  <link rel="stylesheet" href="product_card.css">
  <style>
    .produto-wrap { max-width:1100px; margin:30px auto; display:grid; grid-template-columns: 360px 1fr; gap:30px; align-items:start }
    .produto-imagem { background:#f6fff6; padding:20px; border-radius:12px }
    .produto-imagem img { width:100%; height:auto; object-fit:contain }
    .produto-dados { display:flex; flex-direction:column; gap:16px }
    .preco { font-size:28px; color:#145a2b; font-weight:800 }
    .botao-comprar { background:#1f5d33; color:white; padding:12px 20px; border-radius:24px; text-decoration:none; display:inline-block }
  </style>
</head>
<body>
  <main style="padding-top:120px; max-width:1100px; margin:0 auto;">
    <a href="index.php">← Voltar</a>
    <div class="produto-wrap">
      <div class="produto-imagem">
        <?php if (!empty($produto['imagem'])): $img = $produto['imagem']; $imgSrc = (preg_match('#^(https?:)?//#i', $img) || strpos($img, '/') === 0) ? $img : '../' . $img; ?>
          <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
        <?php else: ?>
          <div style="height:300px;background:#fff;border-radius:8px"></div>
        <?php endif; ?>
      </div>

      <div class="produto-dados">
        <h1><?= htmlspecialchars($produto['nome']) ?></h1>
        <div class="categoria" style="color:#8a9b8a;font-weight:700"><?= htmlspecialchars($produto['categoria'] ?? '') ?></div>
        <div class="preco">R$ <?= number_format((float)$produto['valor'],2,',','.') ?></div>
        <form method="POST" action="../controllers/cart_db.php" style="margin-top:10px">
          <input type="hidden" name="action" value="add">
          <input type="hidden" name="product_id" value="<?= htmlspecialchars($produto['id']) ?>">
          <input type="hidden" name="return" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
          <label>Quantidade: <input type="number" name="quantity" value="1" min="1" style="width:60px"></label>
          <button type="submit" class="botao-comprar">Adicionar ao carrinho</button>
        </form>

        <div style="background:#dfe6df;padding:20px;border-radius:12px;margin-top:20px">
          <h3>Descricao</h3>
          <p><?= nl2br(htmlspecialchars($produto['descricao'])) ?></p>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
