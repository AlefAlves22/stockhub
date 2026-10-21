<?php
// Inicia ou recupera a sessão ativa do usuário no navegador (necessário para controle de login)
session_start();

// Inclui o arquivo de funções gerais do sistema (onde a função relatorio está definida)
require_once __DIR__ . '/../includes/functions.php';

// Inclui o script de segurança (garante que apenas usuários autenticados acessem a página)
require_once __DIR__ . '/../login/verifica_user.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatorio Produtos</title>
    <link rel="stylesheet" href="/stockhub/css/style.css">
</head>
<body>
    <!-- Inclui o cabeçalho/menu padrão das páginas do sistema -->
    <?php include __DIR__ .'/../includes/header.php';?>
    
    <main>
        <!-- Título principal da página de relatório -->
        <h1>Produtos cadastrados no sistema.</h1>
        
        <?php 
        // Chama a função responsável por consultar e exibir a listagem/relatório de produtos no banco de dados
        relatorio($conexao);
        ?>
    </main>
    
    <!-- Inclui o rodapé padrão das páginas do sistema -->
    <?php include __DIR__ .'/../includes/footer.php';?>
</body>
</html>