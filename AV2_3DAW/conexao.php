<?php
$host = "localhost";
$banco = "salao_de_beleza";
$usuario = "root";
$senha = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(["sucesso" => false, "mensagem" => "Erro de conexão: " . $e->getMessage()]);
    exit;
}
?>