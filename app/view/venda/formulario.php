<!DOCTYPE html>
<html>
<head><title>Registrar Venda</title></head>
<body>

<h1>Registrar Venda</h1>

<form method="POST" action="index.php?controller=venda&action=registrar">
    <label>Produto:</label>
    <select name="id_produto" required>
        <?php foreach ($produtos as $produto): ?>
            <option value="<?= $produto['id'] ?>">
                <?= $produto['nome'] ?> (Estoque: <?= $produto['estoque'] ?>)
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Quantidade:</label>
    <input type="number" name="quantidade" min="1" required><br><br>

    <button type="submit">Vender</button>
</form>

<a href="index.php?controller=produto&action=listar">Voltar</a>
</body>
</html>
