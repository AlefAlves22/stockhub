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
    <title>Cadastrar Produto</title>
</head>
<body>
    <?php include __DIR__ . '/../includes/header.php';?>
    <h1>Cadastar Produto</h1>
    <main>
        <form action="" method="post">
            <label for="nome_produto">Nome: </label>
            <input type="text" name="nome_produto" id="nome_produto"><br>
            <label for="sku">SKU: </label>
            <input type="text" name="sku" id="sku"><br>
            <label for="valor_final">Valor de Venda: </label>
            <input type="number" step= "0.01" name="valor_final" id="valor_final"><br>
            <label for="valor_entrada">Valor de compra: </label>
            <input type="number" step= "0.01" name="valor_entrada" id="valor_entrada"><br>
            <label for="descricao">Descrição: </label>
            <input type="text" name="descricao" id="descricao"> <br>
            <label for="quantidade_estoque">Estoque: </label>
            <input type="number" name="quantidade_estoque" id="quantidade_estoque"> <br>
            <label for="fornecedor">Fornecedor: </label>
            <input type="text" name="fornecedor" id="fornecedor"> <br>
            <label for="codig_barra">Código de Barras(EAN): </label>
            <input type="number" name="codigo_barra" id="codigo_barra"> <br>
            <input type="reset" value="Limpar">
            <input type="submit" value="Cadastrar">

        </form>
        <?php
        if($_SERVER['REQUEST_METHOD'] == "POST"){
        cadastrar_produto($conexao, $_POST['sku'], $_POST['nome_produto'], $_POST['valor_final'], $_POST['valor_entrada'], $_POST['descricao'], $_POST['codigo_barra']);
        estoque_produto($conexao, $_POST['quantidade_estoque'], $_POST['fornecedor'], $_POST['sku'], $_POST['codigo_barra']);}
        ?>
        <?php include __DIR__ . '/../includes/footer.php';?>
    </main>
</body>
</html>