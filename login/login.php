<?php
// Inicia ou retoma a sessão ativa do usuário no navegador (necessário para armazenar o ID após a autenticação)
session_start();

// Inclui o arquivo de conexão com o banco de dados
require_once __DIR__ . '/../database/connect.php';

// Inclui o arquivo de funções gerais do sistema (onde a função consulta_user está definida)
require_once __DIR__ . '/../includes/functions.php';

// Inicializa a variável responsável por armazenar mensagens de erro de autenticação
$erro = "";

// Verifica se a requisição foi feita via método POST (quando o formulário de login é enviado)
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Captura os valores informados nos campos de e-mail e senha utilizando o operador de coalescência nula
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Executa a função que busca o usuário no banco de dados com base nas credenciais informadas
    $usuario = consulta_user($conexao, $email, $senha);

    // Valida se o usuário foi encontrado e se as credenciais conferem perfeitamente
    if ($usuario && $usuario['email'] == $email && $usuario['senha'] == $senha) {
        // Armazena o ID do usuário na sessão para validar seu acesso em outras páginas
        $_SESSION['id'] = $usuario['id'];
        
        // Redireciona o usuário autenticado para a página inicial do sistema
        header("Location: /stockhub/index.php");
        
        // Interrompe a execução do script para garantir que o redirecionamento ocorra sem vazamento de código
        exit();
    } else {
        // Define a mensagem de erro a ser exibida na interface caso a autenticação falhe
        $erro = "Usuário ou senha inválidos.";
    }
}
?>
<!-- Inclui o cabeçalho/menu padrão das páginas do sistema -->
<?php include __DIR__ . '/../includes/header.php'; ?>
    <link rel="stylesheet" href="/stockhub/css/style.css">

<main>
    <!-- Título da página de login -->
    <h2>Acesso ao Sistema</h2>

    <!-- Exibe a mensagem de erro caso as credenciais sejam inválidas -->
    <?php if (!empty($erro)): ?>
        <p style="color: var(--danger); font-weight: 600;"><?php echo $erro; ?></p>
    <?php endif; ?>

    <!-- Formulário de autenticação que envia os dados via POST para a própria página -->
    <form action="" method="post">
        <!-- Campo para entrada do e-mail -->
        <label for="email">E-mail: </label>
        <input type="email" name="email" id="email" required>

        <!-- Campo para entrada da senha -->
        <label for="senha">Senha: </label>
        <input type="password" name="senha" id="senha" required>

        <!-- Agrupamento de botões de submissão e limpeza -->
        <div>
            <input type="submit" value="Entrar">
            <input type="reset" value="Limpar">
        </div>
    </form>

    <!-- Chamada para novos usuários que ainda não possuem conta -->
    <h5>Não tem cadastro?</h5> 
    
    <!-- Link para redirecionar à tela de cadastro de novos usuários -->
    <a href="/stockhub/login/cadastra_user.php">Cadastrar-se</a>
</main>

<!-- Inclui o rodapé padrão das páginas do sistema -->
<?php include __DIR__ . '/../includes/footer.php'; ?>