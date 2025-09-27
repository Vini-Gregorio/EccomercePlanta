<?php
require_once 'models/Produto.php';

class ProdutoController {
    public function listar() {
        $produtos = Produto::listarTodos();
        include 'views/produto/listar.php';
    }
}
