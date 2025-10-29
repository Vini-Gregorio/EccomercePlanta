<?php
require_once __DIR__ . '/../config/database.php';

class Carrinho {
    public static function addItem(int $idusuario, int $idproduto, int $quantidade = 1) {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('INSERT INTO carrinho (idusuario, idproduto, quantidade) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantidade = quantidade + VALUES(quantidade)');
        $stmt->execute([$idusuario, $idproduto, $quantidade]);
        return $pdo->lastInsertId();
    }

    public static function updateItem(int $idusuario, int $idproduto, int $quantidade) {
        $pdo = Database::connect();
        if ($quantidade <= 0) {
            $stmt = $pdo->prepare('DELETE FROM carrinho WHERE idusuario = ? AND idproduto = ?');
            return $stmt->execute([$idusuario, $idproduto]);
        }
        $stmt = $pdo->prepare('UPDATE carrinho SET quantidade = ?, updated_at = CURRENT_TIMESTAMP WHERE idusuario = ? AND idproduto = ?');
        return $stmt->execute([$quantidade, $idusuario, $idproduto]);
    }

    public static function removeItem(int $idusuario, int $idproduto) {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('DELETE FROM carrinho WHERE idusuario = ? AND idproduto = ?');
        return $stmt->execute([$idusuario, $idproduto]);
    }

    public static function getForUser(int $idusuario) {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('SELECT c.id, c.idusuario, c.idproduto, c.quantidade, p.nome, p.valor, p.imagem, p.estoque
            FROM carrinho c
            JOIN produtos p ON p.id = c.idproduto
            WHERE c.idusuario = ?');
        $stmt->execute([$idusuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function clearForUser(int $idusuario) {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('DELETE FROM carrinho WHERE idusuario = ?');
        return $stmt->execute([$idusuario]);
    }
}
