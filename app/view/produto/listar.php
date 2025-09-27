
<!DOCTYPE html>
<html>
<head><title>Lista de Produtos</title></head>
<body>
<h1>Produtos</h1>
<?php if (!empty($_SESSION['mensagem'])): ?>
    <p style="color: green;"><?= $_SESSION['mensagem'] ?></p>
    <?php unset($_SESSION['mensagem']); ?>
<?php endif; ?> 
<table border="1">
    <tr>
        <th>Nome</th><th>Preço</th><th>Estoque</th><th>Categoria</th>
    </tr>
    <?php foreach ($produtos as $produto): ?>
        <tr>
            <td><?= htmlspecialchars($produto['nome']) ?></td>
            <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
            <td><?= $produto['estoque'] ?></td>
            <td><?= $produto['categoria_tipo'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="index.php?controller=venda&action=formulario">Fazer Venda</a>
</body>
</html>
