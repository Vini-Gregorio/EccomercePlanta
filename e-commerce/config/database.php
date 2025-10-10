<?php
class Database {
    private static $pdo;

    public static function connect() {
        if (!self::$pdo) {
            self::$pdo = new PDO('mysql:host=localhost;dbname=lojavirtual', 'root', '');
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$pdo;
    }
}