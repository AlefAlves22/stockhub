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
    <title>Procurar </title>
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <h1>Procurar Produto</h1>
    <form action="" method="post">
        <label for="sku">Código de Barras: </label>
        <input type="text" name="codigo_barra" id="codigo_barra"><br>
        <input type="submit" value="Procurar">
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Captura o valor do campo 'codiho_barra' enviado pelo formulário
        $codigo_barra = $_POST['codigo_barra'] ?? '';

        // Passa a variável $sku tratada para a função
        consultar($conexao, $codigo_barra);
    }
    ?>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>