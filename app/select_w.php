<?php
// Inicia ou recupera a sessão ativa do usuário no navegador (necessário para controle de login)
session_start();

// Inclui o arquivo de funções gerais do sistema (onde a função consultar está definida)
require_once __DIR__ . '/../includes/functions.php';

// Inclui o script de segurança (garante que apenas usuários autenticados acessem a página)
require_once __DIR__ . '/../login/verifica_user.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procurar Produto</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Inclui o cabeçalho/menu padrão das páginas do sistema -->
    <?php include __DIR__ . '/../includes/header.php'; ?>
    
    <!-- Título principal da página -->
    <h1>Procurar Produto</h1>
    
    <!-- Formulário HTML para busca de produtos via método POST -->
    <form action="" method="post">
        <!-- Campo de entrada para buscar produto pelo Código de Barras -->
        <label for="codigo_barra">Código de Barras: </label>
        <input type="text" name="codigo_barra" id="codigo_barra"><br>
        
        <!-- Botão para enviar a consulta -->
        <input type="submit" value="Procurar">
    </form>
    
    <?php
    // Verifica se a requisição foi realizada via método POST (envio do formulário)
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Captura o código de barras digitado (usando o operador de coalescência nula para evitar warnings caso venha vazio)
        $codigo_barra = $_POST['codigo_barra'] ?? '';

        // Executa a função responsável por pesquisar o produto no banco de dados passando a conexão e o código obtido
        consultar($conexao, $codigo_barra);
    }
    ?>
    
    <!-- Inclui o rodapé padrão das páginas do sistema -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>