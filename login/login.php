<?php
session_start();
require_once __DIR__ . '/../database/connect.php';
require_once __DIR__ . '/../includes/functions.php';

$erro = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $usuario = consulta_user($conexao, $email, $senha);

    if ($usuario && $usuario['email'] == $email && $usuario['senha'] == $senha) {
        $_SESSION['id'] = $usuario['id'];
        header("Location: /projeto_integrador/index.php");
        exit();
    } else {
        $erro = "Usuário ou senha inválidos.";
    }
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>

<main>
    <h2>Acesso ao Sistema</h2>

    <?php if (!empty($erro)): ?>
        <p style="color: var(--danger); font-weight: 600;"><?php echo $erro; ?></p>
    <?php endif; ?>

    <form action="" method="post">
        <label for="email">E-mail: </label>
        <input type="email" name="email" id="email" required>

        <label for="senha">Senha: </label>
        <input type="password" name="senha" id="senha" required>

        <div>
            <input type="submit" value="Entrar">
            <input type="reset" value="Limpar">
        </div>
    </form>

    <h5>Não tem cadastro?</h5> 
    <a href="/projeto_integrador/login/cadastra_user.php">Cadastrar-se</a>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>