<?php
session_start();

$msg = $_GET['msg'] ?? "";

// se já está logado, decide para onde vai
if (isset($_SESSION["usuario_id"]) && $_SESSION["primeiro_acesso"] == 0) {
    header("Location: index.php");
    exit();
}

// logado, mas ainda no primeiro acesso: mostra a troca de senha
$pagina = "login";

if (isset($_SESSION["usuario_id"]) && $_SESSION["primeiro_acesso"] == 1) {
    $pagina = "trocar_senha";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Mundo Express!</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div id="container">
        <header>
            <img src="imgs/MeuMundoLogo.png" alt="Logo">
            <span id="logo">Meu Mundo Express!</span>
        </header>
        <nav>
            <span class="miniTitle">
                Bem-vindo ao <b>Meu Mundo Express!</b>
            </span>
        </nav>
        <main>
            <?php if ($pagina == "login") { ?>
                <h2>Login</h2>
                <?php
                if ($msg == "erro") {
                    echo "<p>Usuário ou senha inválidos.</p>";
                }
                if ($msg == "bloqueado") {
                    echo "<p>Usuário bloqueado após 3 tentativas erradas. Procure o administrador.</p>";
                }
                if ($msg == "sair") {
                    echo "<p>Você saiu do sistema.</p>";
                }
                ?>
                <form action="crud.php" method="post">
                    <input type="hidden" name="acao" value="login">
                    <label>Usuário</label>
                    <input type="text" name="login" required>
                    <label>Senha</label>
                    <input type="password" name="senha" required>
                    <button type="submit">Entrar</button>
                </form>
            <?php } ?>

            <?php if ($pagina == "trocar_senha") { ?>
                <h2>Troca de Senha</h2>
                <p>Este é o seu primeiro acesso. Defina uma nova senha para continuar.</p>
                <?php
                if ($msg == "diferentes") {
                    echo "<p>A nova senha e a confirmação não são iguais.</p>";
                }
                if ($msg == "curta") {
                    echo "<p>A nova senha deve ter pelo menos 4 caracteres.</p>";
                }
                if ($msg == "igual") {
                    echo "<p>A nova senha não pode ser igual à senha atual.</p>";
                }
                ?>
                <form action="crud.php" method="post">
                    <input type="hidden" name="acao" value="trocar_senha">
                    <label>Nova Senha</label>
                    <input type="password" name="nova" required>
                    <label>Confirmar Nova Senha</label>
                    <input type="password" name="confirmar" required>
                    <button type="submit">Salvar Nova Senha</button>
                </form>
            <?php } ?>
        </main>
        <footer>
            <hr>
            <p>Por Samuel M. 2026 ©</p>
            <hr>
        </footer>
    </div>
</body>
</html>