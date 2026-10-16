<?php
$host = "192.168.10.43";
$dbname = "stockhub";
$user = "estoquista";
$pass = "estoque";

try {
    $conexao = new PDO(
        "pgsql:host=$host;dbname=$dbname",
        $user,
        $pass
    );
    echo "Conexão realizada com sucesso!";
}
catch (PDOException $e){
    echo "Erro: " . $e->getMessage();
}
?>