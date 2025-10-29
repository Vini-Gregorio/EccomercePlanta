<?php 
include_once('../config/database.php')
class Planta {
    private $nome;
    private $tipo;
    private $descricao;
    private $valor;
    private $estoque;

    public static function cadastrarPlanta($nome, $categorias, $descricao, $valor, $estoque, $imagemCaminho = null) {
        $pdo = Database::connect();
        $id_categoria = null;
        if (!empty($categorias)) {
            $cat = $categorias[0];
            $sqlCat = "SELECT id FROM categoria WHERE tipo = ? LIMIT 1";
            $stmtCat = $pdo->prepare($sqlCat);
            $stmtCat->execute([$cat]);
            $rowCat = $stmtCat->fetch(PDO::FETCH_ASSOC);
            if ($rowCat) {
                $id_categoria = $rowCat['id'];
            }
        }
        if (!$id_categoria) {
            $sqlInsertCat = "INSERT INTO categoria (tipo) VALUES (?)";
            $pdo->prepare($sqlInsertCat)->execute([$cat]);
            $id_categoria = $pdo->lastInsertId();
        }
        $sql = "INSERT INTO produtos (nome, id_categoria, descricao, valor, estoque, imagem) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $nome,
            $id_categoria,
            $descricao,
            $valor,
            $estoque,
            $imagemCaminho
        ]);
    }

    public static function listarTodos() {
        $pdo = Database::connect();
        $sql = "SELECT p.*, c.tipo as categoria_tipo 
                FROM produtos p 
                JOIN categoria c ON p.id_categoria = c.id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscarPorId($id) {
        $pdo = Database::connect();
        $sql = "SELECT * FROM produtos WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function atualizarEstoque($id, $novoEstoque) {
        $pdo = Database::connect();
        $sql = "UPDATE produtos SET estoque = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$novoEstoque, $id]);
    }

}