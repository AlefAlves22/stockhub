<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';

// Busca as listas para os datalists do HTML
$clientes = vendas_cliente($conexao);
$vendedor = vendas_vendedor($conexao);
$produtos = vendas_produto($conexao);

// Variáveis de controle dos campos e mensagens
$mensagem               = '';
$nome_cliente_digitado  = $_POST['nome_cliente'] ?? '';
$nome_vendedor_digitado = $_POST['nome_vendedor'] ?? '';
$nome_produto_digitado  = $_POST['nome_produto'] ?? '';
$quantidade_digitada    = $_POST['quantidade'] ?? 1;
$estoque_disponivel     = null;

// Quando o formulário for enviado (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // BOTÃO 1: "Ver Estoque"
    if (isset($_POST['btn_consultar'])) {
        if (!empty($nome_produto_digitado)) {
            // Consulta o estoque atual do produto
            $estoque_disponivel = buscar_quantidade_estoque($conexao, $nome_produto_digitado);
        } else {
            $mensagem = "Informe o nome de um produto para verificar o estoque!";
        }
    }

    // BOTÃO 2: "Confirmar Venda"
    if (isset($_POST['btn_finalizar'])) {
        $qtd_pedida = (int)$quantidade_digitada;
        
        // Busca o estoque atual no banco para conferir
        $estoque_atual = buscar_quantidade_estoque($conexao, $nome_produto_digitado);

        // Validação dos campos
        if (empty($nome_cliente_digitado) || empty($nome_vendedor_digitado) || empty($nome_produto_digitado)) {
            $mensagem = "Por favor, preencha todos os campos do formulário!";
        } elseif ($qtd_pedida <= 0) {
            $mensagem = "A quantidade vendida deve ser maior que zero!";
        } elseif ($qtd_pedida > $estoque_atual) {
            $mensagem = "Erro: Você tentou vender $qtd_pedida, mas só existem $estoque_atual item(ns) no estoque!";
            $estoque_disponivel = $estoque_atual; // Mantém a quantidade visível na tela
        } else {
            // 1. Grava a venda na tabela 'vendas'
            $sucesso_venda = registrar_venda($conexao, $nome_cliente_digitado, $nome_vendedor_digitado, $nome_produto_digitado, $qtd_pedida);

            if ($sucesso_venda) {
                // 2. Abate do estoque
                vendas_estoque($conexao, $nome_produto_digitado, $qtd_pedida);
                
                $mensagem = "Venda realizada com sucesso! Abatido $qtd_pedida item(ns) do estoque.";
                
                // Limpa os campos após a venda
                $nome_cliente_digitado  = '';
                $nome_vendedor_digitado = '';
                $nome_produto_digitado  = '';
                $quantidade_digitada    = 1;
                $estoque_disponivel     = null;
            } else {
                $mensagem = "Erro ao registrar a venda no banco de dados.";
            }
        }
    }
}
?>

<?php include __DIR__ . '/../includes/header.php'; ?>
    <link rel="stylesheet" href="/stockhub/css/style.css">
<h1>Registro de Venda</h1>

<main>
    <!-- Exibe avisos ou mensagens para o usuário -->
    <?php if (!empty($mensagem)): ?>
        <p><strong><?= htmlspecialchars($mensagem) ?></strong></p>
    <?php endif; ?>

    <form action="" method="post">
        
        <!-- Cliente -->
        <label for="nome_cliente">Cliente:</label><br>
        <input type="text" name="nome_cliente" id="nome_cliente" list="clientes-list" value="<?= htmlspecialchars($nome_cliente_digitado) ?>"><br>
        <datalist id="clientes-list">
            <?php foreach ($clientes as $c): ?>
                <option value="<?= htmlspecialchars($c['nome_cliente']) ?>">
            <?php endforeach; ?>
        </datalist>
        <br>

        <!-- Vendedor -->
        <label for="nome_vendedor">Vendedor:</label><br>
        <input type="text" name="nome_vendedor" id="nome_vendedor" list="vendedor-list" value="<?= htmlspecialchars($nome_vendedor_digitado) ?>"><br>
        <datalist id="vendedor-list">
            <?php foreach ($vendedor as $v): ?>
                <option value="<?= htmlspecialchars($v['nome_vendedor']) ?>">
            <?php endforeach; ?>
        </datalist>
        <br>

        <!-- Produto -->
        <label for="nome_produto">Produto:</label><br>
        <input type="text" name="nome_produto" id="nome_produto" list="produto-list" value="<?= htmlspecialchars($nome_produto_digitado) ?>">
        
        <!-- BOTÃO 1: Apenas consulta o estoque -->
        <button type="submit" name="btn_consultar">Ver Estoque</button>

        <datalist id="produto-list">
            <?php foreach ($produtos as $p): ?>
                <option value="<?= htmlspecialchars($p['nome_produto']) ?>">
            <?php endforeach; ?>
        </datalist>
        <br>

        <!-- Se clicou em "Ver Estoque", mostra o número na tela -->
        <?php if ($estoque_disponivel !== null): ?>
            <p>Quantidade em estoque: <strong><?= $estoque_disponivel ?></strong></p>
        <?php endif; ?>

        <br>

        <!-- Quantidade da Venda -->
        <label for="quantidade">Quantidade a Vender:</label><br>
        <input type="number" name="quantidade" id="quantidade" min="1" value="<?= htmlspecialchars($quantidade_digitada) ?>"><br><br>

        <!-- BOTÃO 2: Confirma a Venda, grava na tabela vendas e dá baixa no estoque -->
        <button type="submit" name="btn_finalizar">Confirmar Venda</button>

    </form>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>