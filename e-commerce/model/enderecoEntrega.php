<?php
require_once 'core/Database.php';

class EnderecoEntrega {
    public static function salvar($cidade, $uf, $cep, $bairro, $rua, $numero, $usuario_id) {
        $pdo = Database::connect();
        $sql = "INSERT INTO endereco(cidade, uf, cep, bairro, rua, numero, usuario_id)
                VALUES ( ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$cidade, $uf, $cep, $bairro, $rua, $numero, $usuario_id]);
        return $pdo->lastInsertId();
    }
}
