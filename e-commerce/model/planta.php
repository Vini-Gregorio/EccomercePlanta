<?php
require_once __DIR__ . '/../config/database.php';

class Planta {
    private $nome;
    private $tipo;
    private $descricao;
    private $valor;
    private $estoque;

    
    public static function cadastrarPlanta($nome, $categoria, $descricao, $valor, $estoque, $imagemCaminho = null) {
        $pdo = Database::connect();

        $sql = "INSERT INTO produtos (nome, categoria, descricao, valor, estoque, imagem) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $nome,
            $categoria,
            $descricao,
            $valor,
            $estoque,
            $imagemCaminho
        ]);
    }

    public static function listarTodos() {
        $pdo = Database::connect();
        $sql = "SELECT * FROM produtos";
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