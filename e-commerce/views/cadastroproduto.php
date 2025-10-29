<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cadastro de Produtos</title>
  <link rel="stylesheet" href="cadastroproduto.css">
</head>
<body>
  <div class="container">
    <a href="#" class="back-arrow">← Voltar</a>
    <h1>Cadastro de Produtos</h1>

    <form class="product-form" action="../controllers/produtocontroller.php?acao=cadastrar" method="POST" enctype="multipart/form-data">
      <div class="image-upload">
        <label for="product-image">Imagem do Produto</label>
        <input type="file" id="product-image" name="product-image">
      </div>

      <label for="product-name">Nome Produto</label>
      <input type="text" id="product-name" name="product-name" placeholder="Digite o nome do produto">

      <fieldset>
        <legend>Categoria</legend>
        <div class="checkbox-group">
          <label><input type="checkbox" name="categoria[]" value="Árvores"> Árvores</label>
          <label><input type="checkbox" name="categoria[]" value="Sementes"> Sementes</label>
          <label><input type="checkbox" name="categoria[]" value="Folhas"> Folhas</label>
          <label><input type="checkbox" name="categoria[]" value="Arbustos"> Arbustos</label>
          <label><input type="checkbox" name="categoria[]" value="Para chá"> Para chá</label>
          <label><input type="checkbox" name="categoria[]" value="Temperos"> Temperos</label>
          <label><input type="checkbox" name="categoria[]" value="Flores"> Flores</label>
          <label><input type="checkbox" name="categoria[]" value="Carnívoras"> Carnívoras</label>
        </div>
      </fieldset>

      <label for="description">Descrição</label>
      <textarea id="description" name="description" placeholder="Descrição..."></textarea>

      <div class="inline-fields">
        <div>
          <label for="value">Valor</label>
          <input type="number" id="value" name="value" placeholder="R$" step="0.01">
        </div>
        <div>
          <label for="stock">Qtde Estoque</label>
          <input type="number" id="stock" name="stock" placeholder="0">
        </div>
      </div>

      <button type="submit" class="submit-btn">Cadastrar</button>
    </form>
  </div>
</body>
</html>