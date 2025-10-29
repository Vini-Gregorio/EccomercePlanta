<?php
require_once 'core/Database.php';

class ItemVenda {
    public static function registrar($venda_id, $produto_id, $quantidade, $preco_unitario) {
        $pdo = Database::connect();
        $sql = "INSERT INTO itens_venda (venda_id, produto_id, quantidade, preco_unitario) 
            VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$venda_id, $produto_id, $quantidade, $preco_unitario]);
    }
}