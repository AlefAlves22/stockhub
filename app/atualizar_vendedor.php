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

            <label for="nome_vendedor">Nome: </label>
            <input type="text" name="nome_vendedor" id="nome_vendedor"><br>

            <label for="cpf">CPF: </label>
            <input type="text" name="cpf" id="cpf"><br>

            <input type="reset" value="Limpar">
            <input type="submit" value="Atualizar">

        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            atualizar_vendedor(
                $conexao,
                $_POST['id'],         
                $_POST['nome_vendedor'],
                $_POST['cpf']
            );
        }
        ?>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>