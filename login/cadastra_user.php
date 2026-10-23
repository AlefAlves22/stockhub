<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../database/connect.php';

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="/stockhub/css/style.css">

</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main>
        <form action="" method="post">
            <label for="email">Email: </label>
            <input type="email" name="email" required pattern="[^@\s]+@[^@\s]+\.[^@\s]+"
                title="O e-mail precisa conter um @ e pelo menos um ponto (.)"> <label for="senha">Senha: </label>
            <input type="password" name="senha" id="senha"><br>
            <label for="nome">Nome: </label>
            <input type="text" name="nome" id="nome"><br>
            <label for="cpf">CPF: </label>
            <input type="text" name="cpf" id="cpf"><br>
            <input type="reset" value="Limpar">
            <input type="submit" value="Cadastrar">

        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            cadastrar_user($conexao, $_POST['email'], $_POST['senha'], $_POST['nome'], $_POST['cpf']);
            header("Location: /stockhub/index.php");
            exit();
        }
        ?>
        <?php include __DIR__ . '/../includes/footer.php'; ?>
    </main>
</body>

</html>