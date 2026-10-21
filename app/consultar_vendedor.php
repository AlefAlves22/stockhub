<?php
// Inicia ou recupera a sessão ativa do usuário no navegador (necessário para controle de login)
session_start();

// Inclui o arquivo de funções gerais do sistema (onde a função consultar_vendedor está declarada)
require_once __DIR__ . '/../includes/functions.php';

// Inclui a verificação de segurança (garante que apenas usuários autenticados acessem a página)
require_once __DIR__ . '/../login/verifica_user.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Define a codificação de caracteres como UTF-8 (suporte a acentos e caracteres especiais) -->
    <meta charset="UTF-8">
    <!-- Configura a viewport para garantir ajuste visual adequado em dispositivos móveis -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título da página exibido na aba do navegador -->
    <title>Procurar Vendedor</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Inclui o cabeçalho/menu padrão das páginas do sistema -->
    <?php include __DIR__ . '/../includes/header.php'; ?>
    
    <!-- Título principal visível na página -->
    <h1>Procurar Vendedor</h1>
    
    <!-- Formulário HTML que envia os dados de busca via método POST para a própria página -->
    <form action="" method="post">
        <!-- Campo para informar o CPF do vendedor para busca -->
        <label for="cpf">CPF: </label>
        <input type="text" name="cpf" id="cpf"><br>
        
        <!-- Botão para enviar o formulário e disparar a consulta -->
        <input type="submit" value="Procurar">
    </form>
    
    <?php
    // Verifica se a requisição foi feita via método POST (disparado ao enviar o formulário)
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Captura o CPF enviado pelo formulário, usando o operador de coalescência nula (??) para evitar erros caso venha vazio
        $cpf = $_POST['cpf'] ?? '';

        // Executa a função de consulta passando a conexão com o banco e o CPF informado
        consultar_vendedor($conexao, $cpf);
    }
    ?>
    
    <!-- Inclui o rodapé padrão das páginas do sistema -->
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>