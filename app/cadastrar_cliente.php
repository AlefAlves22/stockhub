<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php';?>
    <h1>Cadastar Cliente</h1>
    <main>
        <form action="" method="post">
            <label for="nome_cliente">Nome: </label>
            <input type="text" name="nome_cliente" id="nome_cliente"><br>
            <label for="cpf">CPF: </label>
            <input type="text" name="cpf" id="cpf"><br>
            <label for="telefone">Telefone: </label>
            <input type="tel" name="telefone" id="telefone"><br>
            <label for="endereco">Endereço: </label>
            <input type="text" name="endereco" id="endereco"><br>
            <input type="reset" value="Limpar">
            <input type="submit" value="Cadastrar">

        </form>
        <?php

        if($_SERVER['REQUEST_METHOD'] == "POST"){
        cadastrar_cliente($conexao, $_POST['nome_cliente'], $_POST['cpf'], $_POST['telefone'], $_POST['endereco']) ;}

        ?>
        <?php include __DIR__ . '/../includes/footer.php';?>
    </main>
</body>
</html>