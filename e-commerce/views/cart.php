<?php
require_once __DIR__ . '/../config/require_login.php';
require_once __DIR__ . '/../model/carrinho.php';

$userId = (int)$_SESSION['user_id'];
$items = Carrinho::getForUser($userId);
$total = 0.0;
foreach ($items as $it) {
    $total += ((float)($it['valor'] ?? 0)) * ((int)$it['quantidade']);
}
$postTarget = '../controllers/cart_db.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Carrinho</title>
  <link rel="stylesheet" href="cadastroproduto.css">
  <style>
    .search { margin-bottom:12px }
    table.cart { width:100%; border-collapse:collapse }
    table.cart th, table.cart td { padding:8px; border-bottom:1px solid #eee; text-align:left }
    .qty-input { width:64px }
    .actions form { display:inline-block; margin-right:6px }
  </style>
</head>
<body>
  <main style="max-width:1000px;margin:40px auto">
    <h1>Carrinho</h1>

    <?php if (empty($items)): ?>
      <p>Seu carrinho está vazio.</p>
      <p><a href="index.php">Continuar comprando</a></p>
    <?php else: ?>

      <div class="search">
        <label>Pesquisar no carrinho: <input id="cart-search" type="search" placeholder="Procure por nome de produto"></label>
      </div>

      <table class="cart">
        <thead>
          <tr>
            <th>Imagem</th>
            <th>Produto</th>
            <th>Preço</th>
            <th>Qtd</th>
            <th>Subtotal</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="cart-body">
          <?php foreach ($items as $it):
            $prodId = htmlspecialchars($it['idproduto'] ?? $it['id']);
            $nome = htmlspecialchars($it['nome'] ?? '');
            $valor = number_format((float)($it['valor'] ?? 0), 2, ',', '.');
            $quant = (int)($it['quantidade'] ?? 1);
            $subtotal = number_format(((float)($it['valor'] ?? 0)) * $quant, 2, ',', '.');
            $img = $it['imagem'] ?? '';
            $imgSrc = '';
            if ($img) {
                $img = trim($img);
                $imgSrc = (preg_match('#^(https?:)?//#i', $img) || strpos($img, '/') === 0) ? $img : '../' . $img;
            }
          ?>
          <tr data-name="<?= strtolower($nome) ?>">
            <td><?php if ($imgSrc): ?><img src="<?= htmlspecialchars($imgSrc) ?>" style="max-width:80px;border-radius:6px"><?php endif; ?></td>
            <td><?= $nome ?></td>
            <td>R$ <?= $valor ?></td>
            <td>
              <form method="POST" action="<?= $postTarget ?>">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="product_id" value="<?= $prodId ?>">
                <input class="qty-input" type="number" name="quantity" min="0" value="<?= $quant ?>">
                <input type="hidden" name="return" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                <button type="submit">Atualizar</button>
              </form>
            </td>
            <td>R$ <?= $subtotal ?></td>
            <td class="actions">
              <form method="POST" action="<?= $postTarget ?>">
                <input type="hidden" name="action" value="remove">
                <input type="hidden" name="product_id" value="<?= $prodId ?>">
                <input type="hidden" name="return" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                <button type="submit">Remover</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <p style="font-weight:600">Total: R$ <?= number_format($total,2,',','.') ?></p>
      <p><a href="index.php">Continuar comprando</a> | <a href="#">Finalizar compra</a></p>

    <?php endif; ?>

  </main>

  <script>
    // client-side search filter
    const searchInput = document.getElementById('cart-search');
    if (searchInput) {
      searchInput.addEventListener('input', function(){
        const q = this.value.trim().toLowerCase();
        document.querySelectorAll('#cart-body tr').forEach(tr => {
          const name = tr.getAttribute('data-name') || '';
          tr.style.display = q === '' || name.indexOf(q) !== -1 ? '' : 'none';
        });
      });
    }
  </script>
</body>
</html>
