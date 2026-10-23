<?php
$host = "192.168.10.43";
$port = "5432";
$dbname = "stockhub";
$user = "estoquista";
$pass = "estoque";

try {
    $conexao = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "Conexão realizada com sucesso!";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}