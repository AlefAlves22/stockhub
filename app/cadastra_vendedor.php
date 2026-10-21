<?php
// Inicia ou recupera a sessão ativa do usuário no navegador (necessário para controle de autenticação)
session_start();

// Inclui o arquivo de funções utilitárias do sistema (onde a função atualizar_vendedor está declarada)
require_once __DIR__ . '/../includes/functions.php';

// Inclui o script de segurança que valida se o usuário tem permissão para acessar a página
require_once __DIR__ . '/../login/verifica_user.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- Define a codificação de caracteres como UTF-8 para suporte a acentuação e caracteres especiais -->
    <meta charset="UTF-8">
    <!-- Configura a viewport para garantir ajuste adequado em telas de dispositivos móveis -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título exibido na aba do navegador -->
    <title>Atualizar Vendedor</title>
</head>

<body>
    <!-- Inclui o cabeçalho/menu padrão do sistema -->
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main>
        <!-- Formulário HTML que envia os dados informados via método POST para a própria página -->
        <form action="" method="post">
            <!-- Campo de entrada para o ID do vendedor a ser atualizado (obrigatório) -->
            <label for="id">ID: </label>
            <input type="number" name="id" id="id" placeholder="Insira ID para atualizar" required><br>

            <!-- Campo para atualizar o Nome do Vendedor -->
            <label for="nome_vendedor">Nome: </label>
            <input type="text" name="nome_vendedor" id="nome_vendedor"><br>

            <!-- Campo para atualizar o CPF do Vendedor -->
            <label for="cpf">CPF: </label>
            <input type="text" name="cpf" id="cpf"><br>

            <!-- Botão para redefinir/limpar os campos do formulário -->
            <input type="reset" value="Limpar">
            <!-- Botão de submissão do formulário -->
            <input type="submit" value="Atualizar">

        </form>

        <?php
        // Verifica se a requisição foi realizada via método POST (quando o formulário é enviado)
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // Chama a função de atualização passando a conexão do BD e os dados informados no formulário
            atualizar_vendedor(
                $conexao,
                $_POST['id'],         
                $_POST['nome_vendedor'],
                $_POST['cpf']
            );
        }
        ?>
    </main>

    <!-- Inclui o rodapé padrão do sistema -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>