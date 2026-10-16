<?php 
session_start();
require_once __DIR__ .'/../includes/functions.php';
require_once __DIR__ .'/../login/verifica_user.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar </title>
</head>
<body>
    <?php include __DIR__ .'/../includes/header.php';?>
    <h1>Apaga Produto</h1>
    <form action="" method="post">
        <label for="sku">SKU: </label>
        <input type="text" name="sku" id="sku"><br>
        <input type="submit" value="Apagar">
    </form>
    <?php
    if($_SERVER['REQUEST_METHOD'] == "POST")
    apagar($conexao, $_POST['sku']);
    ?>
    <?php include __DIR__ .'/../includes/footer.php';?>
</body>
</html>