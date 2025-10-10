<?php
require_once 'core/Database.php';


class Venda {
    public static function registrar($usuario_id, $valor_total, $forma_pagamento, $endereco_id) {
        $pdo = Database::connect();
        $sql = "INSERT INTO vendas (usuario_id, data_venda, valor, forma_pagamento, endereco_id)
                VALUES (?, NOW(), ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$usuario_id, $valor_total, $forma_pagamento, $endereco_id]);
        return $pdo->lastInsertId();
    }
      public static function buscarPorId($id)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM vendas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function listarPorUsuario($usuario_id)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("
            SELECT v.*, e.cidade, e.uf, e.cep, e.bairro, e.rua, e.numero
            FROM vendas v
            JOIN enderecos e ON e.id = v.endereco_id
            WHERE v.usuario_id = ?
            ORDER BY v.data_venda DESC
        ");
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function excluir($id)
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("DELETE FROM vendas WHERE id = ?");
        return $stmt->execute([$id]);
    }
}


