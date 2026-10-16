<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar produto</title>
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main>
        <form action="" method="post">
            <label for="id">ID: </label>
            <input type="number" name="id" id="id" placeholder="Insira ID para atualizar" required><br>

            <label for="sku">SKU: </label>
            <input type="text" name="sku" id="sku"><br>

            <label for="nome_produto">Nome: </label>
            <input type="text" name="nome_produto" id="nome_entrada"><br>

            <label for="valor_final">Valor de venda: </label>
            <input type="decimal" name="valor_final" id="valor_final" step="0,01"><br>

            <label for="valor_entrada">Valor de compra: </label>
            <input type="decimal" name="valor_entrada" id="valor_entrada" step="0.01"><br>

            <label for="descricao">Descrição: </label>
            <input type="text" name="descricao" id="descricao"><br>

            <label for="codigo_barra">Código de barras: </label>
            <input type="number" name="codigo_barra" id="codigo_barra">

            <input type="reset" value="Limpar">
            <input type="submit" value="Atualizar">

        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            atualizar_produto(
                $conexao,
                $_POST['id'],         
                $_POST['sku'],
                $_POST['nome_produto'],
                $_POST['valor_final'],
                $_POST['valor_entrada'],
                $_POST['descricao'],
                $_POST['codigo_barra']
            );
        }
        ?>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>