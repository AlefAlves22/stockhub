<?php
// Inicia ou recupera a sessão ativa do usuário (necessário para controle de login)
session_start();

// Inclui o arquivo de funções gerais do sistema (onde fica a função consultar_cliente)
require_once __DIR__ . '/../includes/functions.php';

// Inclui a verificação de segurança (garante que apenas usuários autenticados acessem a página)
require_once __DIR__ . '/../login/verifica_user.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Define a codificação de caracteres como UTF-8 (suporte a acentos) -->
    <meta charset="UTF-8">
    <!-- Configura a viewport para garantir responsividade em telas de celulares e tablets -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título exibido na aba do navegador -->
    <title>Procurar </title>
</head>

<body>
    <!-- Inclui o cabeçalho/menu padrão das páginas do sistema -->
    <?php include __DIR__ . '/../includes/header.php'; ?>
    
    <!-- Título principal da página -->
    <h1>Procurar CLiente</h1>
    
    <!-- Formulário HTML que envia os dados de busca via método POST para a própria página -->
    <form action="" method="post">
        <!-- Campo para informar o CPF do cliente para busca -->
        <label for="cpf">CPF: </label>
        <input type="text" name="cpf" id="cpf"><br>
        
        <!-- Botão para enviar o formulário e disparar a pesquisa -->
        <input type="submit" value="Procurar">
    </form>
    
    <?php
    // Verifica se o formulário foi enviado via método POST
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Captura o CPF enviado pelo formulário, usando o operador de coalescência nula (??) para evitar erros caso venha vazio
        $cpf = $_POST['cpf'] ?? '';

        // Executa a função de consulta passando a conexão com o banco e o CPF informado
        consultar_cliente($conexao, $cpf);
    }
    ?>
    
    <!-- Inclui o rodapé padrão das páginas do sistema -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>