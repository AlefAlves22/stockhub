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
    <link rel="stylesheet" href="css/style.css">projeto_integrador
</head>

<body>
    <!-- Inclui o cabeçalho/menu padrão das páginas do sistema -->
    <?php include __DIR__ . '/../includes/header.php'; ?>
    
    <!-- Título principal da página de exclusão -->
    <h1>Seja bem-vindo a página de DELETAR: </h1>
    
    <!-- Subtítulo orientando a navegação do usuário -->
    <h2>Escolha o que você quer: </h2>
    
    <!-- Link de navegação para a página de exclusão de produtos -->
    <a href="projeto_integrador/app/delete.php">Excluir Produto</a> <br>
    
    <!-- Link de navegação para a página de exclusão de vendedores -->
    <a href="projeto_integrador/app/delete_vendedor.php">Excluir Vendedor</a> <br>
    
    <!-- Link de navegação para a página de exclusão de clientes -->
    <a href="projeto_integrador/app/delete_cliente.php">Excluir Cliente</a> <br>
    
    <!-- Inclui o rodapé padrão das páginas do sistema -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>