<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';
?>>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php';?>
    <h1>Cadastar Produto</h1>
    <main>
        <form action="" method="post">
            <label for="nome_cliente">Nome: </label>
            <input type="text" name="nome_vendedor" id="nome_vendedor"><br>
            <label for="cpf">CPF: </label>
            <input type="text" name="cpf" id="cpf"><br>
            <input type="reset" value="Limpar">
            <input type="submit" value="Cadastrar">

        </form>
        <?php

        if($_SERVER['REQUEST_METHOD'] == "POST"){
        cadastrar_vendedor($conexao, $_POST['nome_vendedor'], $_POST['cpf']) ;}

        ?>
        <?php include __DIR__ . '/../includes/footer.php';?>
    </main>
</body>
</html>