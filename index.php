<?php
// Front controller / router
define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/config/config.php';
require_once BASE_PATH . '/app/core/Database.php';
require_once BASE_PATH . '/app/controllers/MahasiswaController.php';

// simple router using ?url=...
$url = $_GET['url'] ?? 'mahasiswa';
$url = trim($url, '/');
$segments = explode('/', $url);

$controller = $segments[0] ?: 'mahasiswa';
$method = $segments[1] ?? 'index';
$param = $segments[2] ?? null;

$controllerName = ucfirst($controller) . 'Controller';

if (!class_exists($controllerName)) {
    http_response_code(404);
    echo "Controller $controllerName tidak ditemukan.";
    exit;
}

$c = new $controllerName();

if (!method_exists($c, $method)) {
    http_response_code(404);
    echo "Method $method tidak ditemukan pada controller $controllerName.";
    exit;
}

if ($param) {
    $c->$method($param);
} else {
    $c->$method();
}
