<?php
session_start();
require_once __DIR__ .  '/../model/carrinho.php'; // se ele contém a classe ou funções do carrinho

$usuario_id = $_SESSION['usuario_id'] ?? null;

if (!$usuario_id) {
    echo "<p>Você precisa estar logado para comprar.</p>";
    exit;
}

// Carrega os itens do carrinho diretamente
require_once 'model/Carrinho.php'; // ou o caminho correto para o modelo
$carrinho = Carrinho::getForUser($usuario_id);

if (empty($carrinho)) {
    echo "<p>Seu carrinho está vazio.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Confirmação de Compra</title>
    <link rel="stylesheet" href="compra.css">
</head>
<body>
    <div class="container">
        <?php session_start(); ?>
        <h1>Confirmação de Compra</h1>

        <h2>Itens no Carrinho</h2>
<table>
  <thead>
    <tr>
      <th>Produto</th>
      <th>Quantidade</th>
      <th>Preço Unitário</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($carrinho)): ?>
      <?php foreach ($carrinho as $item): ?>
  <tr>
    <td><?= $item['nome'] ?></td>
    <td><?= $item['quantidade'] ?></td>
    <td>R$ <?= number_format($item['valor'], 2, ',', '.') ?></td>
  </tr>
<?php endforeach; ?>

    <?php else: ?>
      <tr><td colspan="4">Seu carrinho está vazio.</td></tr>
    <?php endif; ?>
  </tbody>
</table>


        <h2>Informações de Entrega</h2>
        <form action="index.php?controller=venda&action=finalizar" method="POST" class="formulario-entrega">
            <input type="text" name="cidade" placeholder="Cidade" required>
            <input type="text" name="uf" placeholder="UF" maxlength="2" required>
            <input type="text" name="cep" placeholder="CEP" required>
            <input type="text" name="bairro" placeholder="Bairro" required>
            <input type="text" name="rua" placeholder="Rua" required>
            <input type="text" name="numero" placeholder="Nº" required>

            <button type="submit" class="botao-confirmar">Confirmar Endereço</button>
        </form>
    </div>
</body>
</html>
