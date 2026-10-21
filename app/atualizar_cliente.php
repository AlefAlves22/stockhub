<?php
// Inicia ou retoma a sessão do usuário (necessário para autenticação/login)
session_start();

// Inclui o arquivo de funções utilitárias/banco de dados (onde deve estar a função atualizar_cliente)
require_once __DIR__ . '/../includes/functions.php';

// Inclui o script de segurança que verifica se o usuário está logado
require_once __DIR__ . '/../login/verifica_user.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Define a codificação de caracteres como UTF-8 (suporta acentos e caracteres especiais) -->
    <meta charset="UTF-8">
    <!-- Ajusta a visualização para dispositivos móveis (responsividade) -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar produto</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Inclui o cabeçalho padrão do site -->
    <?php include __DIR__ . '/../includes/header.php'; ?>
    
    <main>
        <!-- Formulário HTML que envia os dados para a própria página via método POST -->
        <form action="" method="post">
            <!-- Campo para informar o ID do registro que será atualizado (Obrigatório) -->
            <label for="id">ID: </label>
            <input type="number" name="id" id="id" placeholder="Insira ID para atualizar" required><br>

            <!-- Campo para atualizar o Nome do Cliente -->
            <label for="nome_cliente">Nome do Cliente: </label>
            <input type="text" name="nome_cliente" id="nome_cliente"><br>

            <!-- Campo para atualizar o CPF -->
            <label for="cpf">CPF: </label>
            <input type="text" name="cpf" id="cpf"><br>

            <!-- Campo para atualizar o Telefone -->
            <label for="telefone">Telefone: </label>
            <input type="text" name="telefone" id="telefone"><br>

            <!-- Campo para atualizar o Endereço -->
            <label for="endereco">Endereço: </label>
            <input type="text" name="endereco" id="endereco"><br>

            <!-- Botão para limpar os campos do formulário -->
            <input type="reset" value="Limpar">
            <!-- Botão para submeter o formulário -->
            <input type="submit" value="Atualizar">

        </form>

        <?php
        // Verifica se a requisição atual é do tipo POST (ou seja, se o formulário foi enviado)
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // Chama a função responsável por atualizar os dados do cliente no banco de dados,
            // passando a conexão PDO/MySQLi e os dados recebidos via $_POST
            atualizar_cliente(
                $conexao,
                $_POST['id'],
                $_POST['nome_cliente'],
                $_POST['cpf'],
                $_POST['telefone'],
                $_POST['endereco']
            );
        }
        ?>
    </main>
    
    <!-- Inclui o rodapé padrão do site -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>