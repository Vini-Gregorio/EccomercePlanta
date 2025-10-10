<?php
require_once __DIR__ . '/../config/require_login.php';
require_once __DIR__ . '/../model/planta.php';
$produtos = Planta::listarTodos();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Estoque</title>
  <link rel="stylesheet" href="cadastroproduto.css">
  <style>
    /* Palette and visual harmony with cadastroproduto.css */
    .stock-container { max-width: 900px; margin: 30px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.08); }
    .stock-header { display:flex; align-items:center; justify-content:space-between; gap:10px; }
    .search-input { flex:1; padding:10px; border:1px solid #ccc; border-radius:4px; }
    .create-btn { background:#28a745; color:#fff; padding:10px 14px; border-radius:4px; text-decoration:none; }
    table { width:100%; border-collapse: collapse; margin-top:20px; }
    th, td { padding:10px; border-bottom:1px solid #eee; text-align:left; }
    th { background:#f8f9fa; }
    tr:hover { background:#f1f7f1; }
    .img-cell img{ max-width:80px; height:auto; border-radius:4px; }
    .no-results { padding:20px; text-align:center; color:#666; }
  </style>
</head>
<body>
  <div class="stock-container">
    <div class="stock-header">
      <h1>Estoque</h1>
      <div style="display:flex; gap:10px; width:100%; align-items:center;">
        <input id="search" class="search-input" placeholder="Pesquisar produto..." />
        <a class="create-btn" href="cadastroproduto.php">+ Novo Produto</a>
      </div>
    </div>

    <div id="table-wrap">
      <?php if (empty($produtos)): ?>
        <div class="no-results">Nenhum produto cadastrado.</div>
      <?php else: ?>
        <table id="produtos-table">
          <thead>
            <tr>
              <th>Imagem</th>
              <th>Nome</th>
              <th>Categoria</th>
              <th>Descrição</th>
              <th>Valor</th>
              <th>Estoque</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($produtos as $p): ?>
              <tr>
                  <td class="img-cell"><?php if (!empty($p['imagem'])):
                    $img = trim($p['imagem']);
                    $imgSrc = (preg_match('#^(https?:)?//#i', $img) || strpos($img, '/') === 0) ? $img : '../' . $img;
                  ?>
                    <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($p['nome']) ?>">
                  <?php endif; ?></td>
                <td><?= htmlspecialchars($p['nome']) ?></td>
                <td><?= htmlspecialchars($p['categoria'] ?? '') ?></td>
                <td><?= htmlspecialchars($p['descricao']) ?></td>
                <td>R$ <?= number_format((float)($p['valor'] ?? 0), 2, ',', '.') ?></td>
                <td><?= (int)($p['estoque'] ?? 0) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>

  <script>
    // client-side search
    const search = document.getElementById('search');
    const table = document.getElementById('produtos-table');
    if (search && table) {
      const rows = Array.from(table.querySelectorAll('tbody tr'));
      search.addEventListener('input', () => {
        const q = search.value.trim().toLowerCase();
        let visible = 0;
        rows.forEach(r => {
          const text = r.innerText.toLowerCase();
          const show = q === '' || text.indexOf(q) !== -1;
          r.style.display = show ? '' : 'none';
          if (show) visible++;
        });
        if (visible === 0) {
          if (!document.querySelector('.no-results-inline')) {
            const nr = document.createElement('div');
            nr.className = 'no-results-inline';
            nr.textContent = 'Nenhum produto encontrado.';
            nr.style.padding = '20px';
            nr.style.textAlign = 'center';
            nr.style.color = '#666';
            document.getElementById('table-wrap').appendChild(nr);
          }
        } else {
          const el = document.querySelector('.no-results-inline');
          if (el) el.remove();
        }
      });
    }
  </script>
</body>
</html>
