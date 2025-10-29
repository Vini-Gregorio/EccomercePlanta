<?php
require_once 'core/Database.php';

class Venda {
    public static function registrar($id_produto, $quantidade, $valor_total) {
        $pdo = Database::connect();
        $sql = "INSERT INTO venda (id_produto, qntd, valortotal, data_venda)
                VALUES (?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id_produto, $quantidade, $valor_total]);
    }
}