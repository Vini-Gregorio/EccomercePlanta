<?php
require_once __DIR__ . '/../model/planta.php';

class ProdutoController {
    public function listar() {
        $produtos = Planta::listarTodos();
        include __DIR__ . '/../views/produto/listar.php';
    }

    public function cadastrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['product-name'] ?? '';
            $descricao = $_POST['description'] ?? '';
            $valor = $_POST['value'] ?? 0;
            $estoque = $_POST['stock'] ?? 0;
            $categorias = isset($_POST['categoria']) ? $_POST['categoria'] : [];
            $categoria = '';
            if (!empty($categorias)) {
                if (is_array($categorias)) {
                    $categoria = $categorias[0];
                } else {
                    $categoria = $categorias;
                }
            }
            $imagemCaminho = null;
            if (isset($_FILES['product-image']) && $_FILES['product-image']['error'] === UPLOAD_ERR_OK) {
                $tmp = $_FILES['product-image']['tmp_name'];
                $nomeArquivo = basename($_FILES['product-image']['name']);
                $destino = '../imgs/' . $nomeArquivo;
                if (move_uploaded_file($tmp, __DIR__ . '/../imgs/' . $nomeArquivo)) {
                    $imagemCaminho = 'imgs/' . $nomeArquivo;
                }
            }
            Planta::cadastrarPlanta($nome, $categoria, $descricao, $valor, $estoque, $imagemCaminho);
            
            header('Location: ../views/estoque.php');
            exit;
        } else {
            include __DIR__ . '/../views/cadastroproduto.php';
        }
    }
}

// Roteador simples
$acao = $_GET['acao'] ?? '';
$controller = new ProdutoController();
if ($acao === 'cadastrar') {
    $controller->cadastrar();
} else {
    $controller->listar();
}