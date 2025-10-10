<?php
require_once 'models/Carrinho.php';
require_once 'models/Venda.php';
require_once 'models/ItemVenda.php';
require_once 'models/Produto.php';

class VendaController {
    public function comprar() {
        session_start();
        $idusuario = $_SESSION['usuario_id'] ?? null;

        if (!$idusuario) {
            $_SESSION['mensagem'] = "Você precisa estar logado para finalizar a compra.";
            header('Location: login.php');
            exit;
        }

        $carrinho = Carrinho::getForUser($idusuario);
        
        include 'comprar.php';
    }

    public function finalizar() {
        session_start();
        $idusuario = $_SESSION['usuario_id'] ?? null;

        if (!$idusuario) {
            $_SESSION['mensagem'] = "Você precisa estar logado.";
            header('Location: login.php');
            exit;
        }

        $carrinho = Carrinho::getForUser($idusuario);

        if (empty($carrinho)) {
            $_SESSION['mensagem'] = "Seu carrinho está vazio.";
            header('Location: produtos.php');
            exit;
        }

        $valor_total = 0;
        foreach ($carrinho as $item) {
            $valor_total += $item['valor'] * $item['quantidade'];
        }

        $endereco = [
            'cidade' => $_POST['cidade'],
            'uf' => $_POST['uf'],
            'cep' => $_POST['cep'],
            'bairro' => $_POST['bairro'],
            'rua' => $_POST['rua'],
            'numero' => $_POST['numero']
        ];

        $venda_id = Venda::registrar($idusuario, $valor_total, 'pix', $endereco);

        foreach ($carrinho as $item) {
            ItemVenda::registrar($venda_id, $item['idproduto'], $item['quantidade'], $item['valor']);
            $novoEstoque = $item['estoque'] - $item['quantidade'];
            Produto::atualizarEstoque($item['idproduto'], $novoEstoque);
        }

        Carrinho::limpar($idusuario);
        $_SESSION['mensagem'] = "Compra finalizada com sucesso!";
        header('Location: produtos.php');
        exit;
    }
}
?>