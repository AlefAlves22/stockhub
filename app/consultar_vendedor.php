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
    <h1>Procurar Vendedor</h1>
    <form action="" method="post">
        <label for="cpf">CPF: </label>
        <input type="text" name="cpf" id="cpf"><br>
        <input type="submit" value="Procurar">
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Captura o valor do campo 'codiho_barra' enviado pelo formulário
        $cpf = $_POST['cpf'] ?? '';

        // Passa a variável $sku tratada para a função
        consultar_vendedor($conexao, $cpf);
    }
    ?>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>