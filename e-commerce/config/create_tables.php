<?php
require_once __DIR__ . '/database.php';

try {
    $pdo = Database::connect();

    $sqlProdutos = "CREATE TABLE IF NOT EXISTS produtos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(255) NOT NULL,
        categoria VARCHAR(255) DEFAULT NULL,
        descricao TEXT,
        valor DECIMAL(10,2) DEFAULT '0.00',
        estoque INT DEFAULT 0,
        imagem VARCHAR(512)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
    $pdo->exec($sqlProdutos);

    echo "Table ensured: produtos (with categoria column)\n";
} catch (PDOException $e) {
    echo "Error creating tables: " . $e->getMessage() . "\n";
    exit(1);
}
