<?php
// Inicia ou retoma a sessão do usuário (necessário para controle de login)
session_start();

// Inclui o arquivo de funções gerais do sistema (onde fica a função atualizar_produto)
require_once __DIR__ . '/../includes/functions.php';

// Inclui a verificação de autenticação (garante que apenas usuários logados acessem a página)
require_once __DIR__ . '/../login/verifica_user.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Define o conjunto de caracteres como UTF-8 -->
    <meta charset="UTF-8">
    <!-- Configura a viewport para garantir responsividade em telas menores -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título da página exibido na aba do navegador -->
    <title>Atualizar produto</title>
    <link rel="stylesheet" href="/stockhub/css/style.css">
</head>

<body>
    <!-- Inclui o cabeçalho padrão da aplicação -->
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main>
        <!-- Formulário para envio de dados via método POST para a própria página -->
        <form action="" method="post">
            <!-- Campo para o ID do produto que será atualizado (obrigatório) -->
            <label for="id">ID: </label>
            <input type="number" name="id" id="id" placeholder="Insira ID para atualizar" required><br>

            <!-- Campo para atualizar o SKU do produto -->
            <label for="sku">SKU: </label>
            <input type="text" name="sku" id="sku"><br>

            <!-- Campo para atualizar o Nome do produto -->
            <label for="nome_produto">Nome: </label>
            <input type="text" name="nome_produto" id="nome_entrada"><br>

            <!-- Campo para o Valor de Venda -->
            <label for="valor_final">Valor de venda: </label>
            <input type="decimal" name="valor_final" id="valor_final" step="0,01"><br>

            <!-- Campo para o Valor de Compra -->
            <label for="valor_entrada">Valor de compra: </label>
            <input type="decimal" name="valor_entrada" id="valor_entrada" step="0.01"><br>

            <!-- Campo para a Descrição do produto -->
            <label for="descricao">Descrição: </label>
            <input type="text" name="descricao" id="descricao"><br>

            <!-- Campo para o Código de Barras do produto -->
            <label for="codigo_barra">Código de barras: </label>
            <input type="number" name="codigo_barra" id="codigo_barra">

            <!-- Botão para limpar os campos preenchidos do formulário -->
            <input type="reset" value="Limpar">
            <!-- Botão para enviar o formulário -->
            <input type="submit" value="Atualizar">

        </form>

        <?php
        // Verifica se a requisição foi feita via