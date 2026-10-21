<?php
// Inicia ou retoma a sessão ativa do usuário no navegador (essencial para autenticação)
session_start();

// Inclui o arquivo de funções gerais do sistema (onde a função cadastrar_cliente está definida)
require_once __DIR__ . '/../includes/functions.php';

// Inclui o script de segurança (garante que apenas usuários autenticados acessem a página)
require_once __DIR__ . '/../login/verifica_user.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Define a codificação de caracteres como UTF-8 (suporte a acentos e caracteres especiais) -->
    <meta charset="UTF-8">
    <!-- Configura a viewport para garantir ajuste visual adequado em telas de dispositivos móveis -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título da página exibido na aba do navegador -->
    <title>Cadastrar Cliente</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Inclui o cabeçalho/menu padrão das páginas do sistema -->
    <?php include __DIR__ . '/../includes/header.php';?>
    
    <!-- Título principal visível na página -->
    <h1>Cadastar Cliente</h1>
    
    <main>
        <!-- Formulário HTML que envia os dados informados via método POST para a própria página -->
        <form action="" method="post">
            <!-- Campo de entrada para o Nome do Cliente -->
            <label for="nome_cliente">Nome: </label>
            <input type="text" name="nome_cliente" id="nome_cliente"><br>
            
            <!-- Campo de entrada para o CPF -->
            <label for="cpf">CPF: </label>
            <input type="text" name="cpf" id="cpf"><br>
            
            <!-- Campo de entrada para o Telefone (usa o tipo específico "tel") -->
            <label for="telefone">Telefone: </label>
            <input type="tel" name="telefone" id="telefone"><br>
            
            <!-- Campo de entrada para o Endereço -->
            <label for="endereco">Endereço: </label>
            <input type="text" name="endereco" id="endereco"><br>
            
            <!-- Botão para limpar/redefinir todos os campos do formulário -->
            <input type="reset" value="Limpar">
            <!-- Botão para enviar os dados digitados -->
            <input type="submit" value="Cadastrar">
        </form>
        
        <?php
        // Verifica se a requisição foi feita via método POST (disparado ao enviar o formulário)
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // Executa a função de cadastro no banco de dados passando a conexão e os parâmetros informados
            cadastrar_cliente(
                $conexao, 
                $_POST['nome_cliente'], 
                $_POST['cpf'], 
                $_POST['telefone'], 
                $_POST['endereco']
            );
        }
        ?>
        
        <!-- Inclui o rodapé padrão das páginas do sistema -->
        <?php include __DIR__ . '/../includes/footer.php';?>
    </main>
</body>
</html>