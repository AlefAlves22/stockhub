<?php 
// Inicia ou retoma a sessão ativa do usuário no navegador (necessário para controle de login)
session_start();

// Inclui o arquivo de funções gerais do sistema (onde a função apagar_vendedor está definida)
require_once __DIR__ .'/../includes/functions.php';

// Inclui o script de segurança (garante que apenas usuários autenticados acessem a página)
require_once __DIR__ .'/../login/verifica_user.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar </title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Inclui o cabeçalho/menu padrão das páginas do sistema -->
    <?php include __DIR__ .'/../includes/header.php';?>
    
    <!-- Título principal visível na página -->
    <h1>Apaga Vendedor</h1>
    
    <!-- Formulário HTML que envia os dados informados via método POST para a própria página -->
    <form action="" method="post">
        <!-- Campo para informar o CPF do vendedor a ser removido -->
        <label for="cpf">CPF: </label>
        <input type="text" name="cpf" id="cpf"><br>
        
        <!-- Botão para enviar o formulário e disparar a exclusão -->
        <input type="submit" value="Apagar">
    </form>
    
    <?php
    // Verifica se a requisição foi feita via método POST (quando o formulário é enviado)
    if($_SERVER['REQUEST_METHOD'] == "POST")
        // Executa a função responsável por excluir o vendedor no banco de dados passando a conexão e o CPF informado
        apagar_vendedor($conexao, $_POST['cpf']);
    ?>
    
    <!-- Inclui o rodapé padrão das páginas do sistema -->
    <?php include __DIR__ .'/../includes/footer.php';?>
</body>
</html>