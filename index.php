<?php
session_start();

$controller = $_GET['controller'] ?? 'produto';
$action = $_GET['action'] ?? 'listar';

$controllerFile = 'controllers/' . ucfirst($controller) . 'Controller.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $className = ucfirst($controller) . 'Controller';

    if (class_exists($className)) {
        $obj = new $className();

        if (method_exists($obj, $action)) {
            $obj->$action();
        } else {
            die("Ação '$action' não encontrada no controller '$className'.");
        }
    } else {
        die("Classe '$className' não encontrada.");
    }
} else {
    die("Controller '$controller' não encontrado.");
}
