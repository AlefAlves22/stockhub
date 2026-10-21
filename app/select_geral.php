<?php
// Inicia ou recupera a sessão ativa do usuário no navegador (necessário para controle de login)
session_start();

// Inclui o arquivo de funções gerais do sistema
require_once __DIR__ . '/../includes/functions.php';

// Inclui o script de segurança (garante que apenas usuários autenticados acessem a página)
require_once __DIR__ . '/../login/verifica_user.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/stockhub/css/style.css">
</head>

<body>
    <!-- Inclui o cabeçalho/menu padrão das páginas do sistema -->
    <?php include __DIR__ . '/../includes/header.php'; ?>
    
    <!-- Título principal da página de relatórios -->
    <h1>Seja bem-vindo a página de RELATÓRIOS: </h1>
    
    <!-- Subtítulo orientando as opções de relatórios disponíveis -->
    <h2>Escolha o que você quer: </h2>
    
    <!-- Link para visualizar o relatório de produtos cadastrados -->
    <a href="/stockhub/app/select.php">Produtos Cadastrados </a> <br>
    <!-- Link para visualizar o relatório de vendedores cadastrados -->
    <a href="/stockhub/app/select_vendedor.php">Vendedores cadastrados</a> <br>
    
    <!-- Link para visualizar o relatório de clientes cadastrados -->
    <a href="/stockhub/app/select_cliente.php">Clientes cadastrados</a> <br>
    
    <!-- Inclui o rodapé padrão das páginas do sistema -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>