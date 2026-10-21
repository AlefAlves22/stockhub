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
    
    <!-- Título principal da página -->
    <h1>Seja bem-vindo a página de CADASTROS: </h1>
    
    <!-- Subtítulo orientando as opções disponíveis para o usuário -->
    <h2>Escolha o que você quer: </h2>
    
    <!-- Link para navegar até a tela de criação/realização de vendas -->
    <a href="venda.php"> Realizar venda</a> <br>
    
    <!-- Link para navegar até o relatório/listagem de vendas já efetuadas -->
    <a href="select_vendas.php"> Vendas realizadas</a> <br>
    
    <!-- Inclui o rodapé padrão das páginas do sistema -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>