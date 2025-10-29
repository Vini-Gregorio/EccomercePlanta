<?php
// Expects $product array with keys: id, nome, categoria, descricao, valor, estoque, imagem
// Optional $showButtonText - label for the action button (default: 'Visualizar')
$showButtonText = $showButtonText ?? 'Visualizar';
// Build detail URL (views/produto.php?id=...)
$detailUrl = '#';
if (!empty($product['id'])) {
  $detailUrl = 'produto.php?id=' . urlencode($product['id']);
}
?>
<div class="product-card">
  <div class="product-image">
    <?php
    $imgPath = trim($product['imagem'] ?? '');
    $imgSrc = '';
    if ($imgPath !== '') {
        // If it's an absolute URL or starts with '/', use as-is
        if (preg_match('#^(https?:)?//#i', $imgPath) || strpos($imgPath, '/') === 0) {
            $imgSrc = $imgPath;
        } else {
            // Image path is likely relative like 'imgs/filename'
            // Check whether the file exists in project root and prefix '../' for views pages
            $possible = __DIR__ . '/../../' . $imgPath; // project root + path
            if (file_exists($possible)) {
                // component is included from a file under `views/`, so prefix ../ to reach project root
                $imgSrc = '../' . $imgPath;
            } else {
                // fallback: use the raw path
                $imgSrc = $imgPath;
            }
        }
    }
    if (!empty($imgSrc)): ?>
      <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($product['nome']) ?>">
    <?php else: ?>
      <div class="placeholder-img"></div>
    <?php endif; ?>
  </div>
  <div class="product-body">
    <h3 class="product-name"><?= htmlspecialchars($product['nome']) ?></h3>
    <div class="product-category"><?= htmlspecialchars($product['categoria'] ?? '') ?></div>
    <div class="product-price">R$ <?= number_format((float)($product['valor'] ?? 0), 2, ',', '.') ?></div>
    <div class="product-action">
      <a class="btn-view" href="<?= htmlspecialchars($detailUrl) ?>"><?= htmlspecialchars($showButtonText) ?></a>
      <form method="POST" action="../controllers/cart_db.php" style="display:inline-block; margin-left:8px">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id'] ?? '') ?>">
        <input type="hidden" name="quantity" value="1">
        <input type="hidden" name="return" value="<?= htmlspecialchars($_SERVER['REQUEST_URI'] ?? 'index.php') ?>">
        <button class="btn-view" type="submit" style="background:#2e7d3a">+</button>
      </form>
    </div>
  </div>
</div>
