<?php
// Inicia ou retoma a sessão ativa do usuário no navegador (necessário para controle de autenticação)
session_start();

// Inclui o arquivo de funções gerais do sistema (onde ficam cadastrar_produto e estoque_produto)
require_once __DIR__ . '/../includes/functions.php';

// Inclui a verificação de segurança (garante que apenas usuários autenticados acessem a página)
require_once __DIR__ . '/../login/verifica_user.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
</head>
<body>
    <!-- Inclui o cabeçalho/menu padrão das páginas do sistema -->
    <?php include __DIR__ . '/../includes/header.php';?>
    
    <!-- Título principal visível na página -->
    <h1>Cadastar Produto</h1>
    
    <main>
        <!-- Formulário HTML que envia os dados informados via método POST para a própria página -->
        <form action="" method="post">
            <!-- Campo de entrada para o Nome do Produto -->
            <label for="nome_produto">Nome: </label>
            <input type="text" name="nome_produto" id="nome_produto"><br>

            <!-- Campo de entrada para o SKU (código identificador de estoque) -->
            <label for="sku">SKU: </label>
            <input type="text" name="sku" id="sku"><br>

            <!-- Campo para o Valor de Venda (permite decimais com incremento de 0.01) -->
            <label for="valor_final">Valor de Venda: </label>
            <input type="number" step="0.01" name="valor_final" id="valor_final"><br>

            <!-- Campo para o Valor de Custo/Compra (permite decimais com incremento de 0.01) -->
            <label for="valor_entrada">Valor de compra: </label>
            <input type="number" step="0.01" name="valor_entrada" id="valor_entrada"><br>

            <!-- Campo de entrada para a Descrição do produto -->
            <label for="descricao">Descrição: </label>
            <input type="text" name="descricao" id="descricao"> <br>

            <!-- Campo para informar a Quantidade Inicial em Estoque -->
            <label for="quantidade_estoque">Estoque: </label>
            <input type="number" name="quantidade_estoque" id="quantidade_estoque"> <br>

            <!-- Campo para informar o Nome do Fornecedor -->
            <label for="fornecedor">Fornecedor: </label>
            <input type="text" name="fornecedor" id="fornecedor"> <br>

            <!-- Campo para o Código de Barras (EAN) -->
            <label for="codig_barra">Código de Barras(EAN): </label>
            <input type="number" name="codigo_barra" id="codigo_barra"> <br>

            <!-- Botão para redefinir/limpar os campos do formulário -->
            <input type="reset" value="Limpar">
            <!-- Botão de submissão do formulário -->
            <input type="submit" value="Cadastrar">
        </form>

        <?php
        // Verifica se a requisição foi realizada via método POST (disparada ao enviar o formulário)
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            // Executa a função responsável por cadastrar os dados principais do produto na tabela correspondente
            cadastrar_produto(
                $conexao, 
                $_POST['sku'], 
                $_POST['nome_produto'], 
                $_POST['valor_final'], 
                $_POST['valor_entrada'], 
                $_POST['descricao'], 
                $_POST['codigo_barra']
            );

            // Executa a função responsável por dar entrada/registrar o estoque inicial e fornecedor do produto
            estoque_produto(
                $conexao, 
                $_POST['quantidade_estoque'], 
                $_POST['fornecedor'], 
                $_POST['sku'], 
                $_POST['codigo_barra']
            );
        }
        ?>

        <!-- Inclui o rodapé padrão das páginas do sistema -->
        <?php include __DIR__ . '/../includes/footer.php';?>
    </main>
</body>
</html>