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
            <!-- Adicionado o campo para identificar o produto -->
            <label for="codigo_barra">Código de Barras: </label>
            <input type="text" name="codigo_barra" id="codigo_barra"><br>

            <label for="quantidade_estoque">Estoque: </label>
            <input type="number" name="quantidade_estoque" id="quantidade_estoque"><br>

            <label for="fornecedor">Fornecedor: </label>
            <input type="text" name="fornecedor" id="fornecedor"><br>

            <button type="submit">Atualizar</button>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $quantidade = $_POST['quantidade_estoque'] ?? 0;
            $fornecedor = $_POST['fornecedor'] ?? '';
            $codigo_barra = $_POST['codigo_barra'] ?? '';

            // Chamada enviando os 4 parâmetros requeridos
            atualizar_estoque($conexao, $quantidade, $fornecedor, $codigo_barra);
        }
        ?>

    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>