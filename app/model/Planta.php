<?php 
include_once('../config/database.php')
public Class Planta {
    private $nome;
    private $tipo;
    private $descricao;
    private $valor;
    private $estoque;

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