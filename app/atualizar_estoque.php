<?php
// Inicia ou recupera a sessão ativa do usuário (essencial para persistência de login)
session_start();

// Inclui o arquivo de funções utilitárias do sistema (onde a função atualizar_estoque deve estar declarada)
require_once __DIR__ . '/../includes/functions.php';

// Inclui a verificação de segurança (redireciona ou bloqueia se o usuário não estiver autenticado)
require_once __DIR__ . '/../login/verifica_user.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Define a codificação de caracteres do documento como UTF-8 -->
    <meta charset="UTF-8">
    <!-- Garante que a página seja exibida corretamente em dispositivos móveis -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título exibido na aba do navegador -->
    <title>Atualizar produto</title>
    <link rel="stylesheet" href="/stockhub/css/style.css">
</head>

<body>
    <!-- Inclui o cabeçalho/menu padrão das páginas do sistema -->
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main>
        <!-- Formulário que envia os dados informados via método POST para a própria página -->
        <form action="" method="post">
            <!-- Campo de entrada para o Código de Barras (usado para localizar o produto) -->
            <label for="codigo_barra">Código de Barras: </label>
            <input type="text" name="codigo_barra" id="codigo_barra"><br>

            <!-- Campo de entrada para a Quantidade em Estoque -->
            <label for="quantidade_estoque">Estoque: </label>
            <input type="number" name="quantidade_estoque" id="quantidade_estoque"><br>

            <!-- Campo de entrada para o Fornecedor -->
            <label for="fornecedor">Fornecedor: </label>
            <input type="text" name="fornecedor" id="fornecedor"><br>

            <!-- Botão de submissão do formulário -->
            <button type="submit">Atualizar</button>
        </form>

        <?php
        // Verifica se a requisição atual é do tipo POST (ou seja, se o formulário foi enviado)
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // Captura os valores enviados via POST, definindo valores padrão caso venham vazios (Coalescência Nula ??)
            $quantidade = $_POST['quantidade_estoque'] ?? 0;
            $fornecedor = $_POST['fornecedor'] ?? '';
            $codigo_barra = $_POST['codigo_barra'] ?? '';

            // Executa a função de atualização de estoque enviando a conexão do BD e os dados informados
            atualizar_estoque($conexao, $quantidade, $fornecedor, $codigo_barra);
        }
        ?>

    </main>

    <!-- Inclui o rodapé padrão das páginas do sistema -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>