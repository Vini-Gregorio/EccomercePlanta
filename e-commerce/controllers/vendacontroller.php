<?php
require_once 'models/Venda.php';
require_once 'models/Produto.php';

class VendaController {
    public function formulario() {
        $produtos = Produto::listarTodos();
        include 'views/venda/formulario.php';
    }

    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_produto = $_POST['id_produto'];
            $quantidade = $_POST['quantidade'];

            $produto = Produto::buscarPorId($id_produto);

            if ($produto && $quantidade > 0 && $quantidade <= $produto['estoque']) {
                $valor_total = $quantidade * $produto['preco'];

                Venda::registrar($id_produto, $quantidade, $valor_total);

                $novoEstoque = $produto['estoque'] - $quantidade;
                Produto::atualizarEstoque($id_produto, $novoEstoque);

                $_SESSION['mensagem'] = "Venda registrada com sucesso!";
            } else {
                $_SESSION['mensagem'] = "Erro: Quantidade inválida ou produto indisponível.";
            }

            header('Location: index.php?controller=produto&action=listar');
            exit;
        }
    }
}