<?php

session_start();

include("conexao.php");

$acao = $_REQUEST["acao"] ?? "";

// grava um evento na tabela logs
function registrar_log($conn, $usuario_id, $login, $evento) {

    $login = mysqli_real_escape_string($conn, $login);

    $sql = "INSERT INTO logs (usuario_id, login_digitado, evento)
            VALUES ($usuario_id, '$login', '$evento')";

    mysqli_query($conn, $sql);
}

/*
   AUTENTICAÇÃO
*/

if ($acao == "login") {

    $login = $_POST["login"];
    $senha = $_POST["senha"];

    $login_seguro = mysqli_real_escape_string($conn, $login);

    $resultado = mysqli_query($conn, "SELECT * FROM usuarios WHERE login = '$login_seguro'");
    $usuario = mysqli_fetch_assoc($resultado);

    // usuário não existe
    if (!$usuario) {
        registrar_log($conn, "NULL", $login, "LOGIN_USUARIO_INEXISTENTE");
        header("Location: index.php?pagina=login&msg=erro");
        exit();
    }

    $id = (int) $usuario["id"];

    // usuário já está bloqueado
    if ($usuario["bloqueado"] == 1) {
        registrar_log($conn, $id, $login, "TENTATIVA_USUARIO_BLOQUEADO");
        header("Location: index.php?pagina=login&msg=bloqueado");
        exit();
    }

    // senha correta
    if (password_verify($senha, $usuario["senha"])) {

        mysqli_query($conn, "UPDATE usuarios SET tentativas_erro = 0 WHERE id = $id");

        registrar_log($conn, $id, $login, "LOGIN_OK");

        session_regenerate_id(true);
        $_SESSION["usuario_id"] = $id;
        $_SESSION["login"] = $usuario["login"];
        $_SESSION["primeiro_acesso"] = $usuario["primeiro_acesso"];

        header("Location: index.php");
        exit();
    }

    // senha errada
    $tentativas = $usuario["tentativas_erro"] + 1;

    if ($tentativas >= 3) {

        mysqli_query($conn, "UPDATE usuarios SET tentativas_erro = $tentativas, bloqueado = 1 WHERE id = $id");

        registrar_log($conn, $id, $login, "USUARIO_BLOQUEADO");

        header("Location: index.php?pagina=login&msg=bloqueado");
        exit();
    }

    mysqli_query($conn, "UPDATE usuarios SET tentativas_erro = $tentativas WHERE id = $id");

    registrar_log($conn, $id, $login, "SENHA_INCORRETA");

    header("Location: index.php?pagina=login&msg=erro");
    exit();
}

if ($acao == "trocar_senha") {

    if (!isset($_SESSION["usuario_id"])) {
        header("Location: index.php?pagina=login");
        exit();
    }

    $id = (int) $_SESSION["usuario_id"];
    $nova = $_POST["nova"];
    $confirmar = $_POST["confirmar"];

    if ($nova != $confirmar) {
        header("Location: index.php?pagina=trocar_senha&msg=diferentes");
        exit();
    }

    if (strlen($nova) < 4) {
        header("Location: index.php?pagina=trocar_senha&msg=curta");
        exit();
    }

    $resultado = mysqli_query($conn, "SELECT senha FROM usuarios WHERE id = $id");
    $usuario = mysqli_fetch_assoc($resultado);

    // não pode continuar com a mesma senha de antes
    if (password_verify($nova, $usuario["senha"])) {
        header("Location: index.php?pagina=trocar_senha&msg=igual");
        exit();
    }

    $hash = password_hash($nova, PASSWORD_DEFAULT);

    mysqli_query($conn, "UPDATE usuarios SET senha = '$hash', primeiro_acesso = 0 WHERE id = $id");

    $_SESSION["primeiro_acesso"] = 0;

    registrar_log($conn, $id, $_SESSION["login"], "SENHA_TROCADA");

    header("Location: index.php");
    exit();
}

if ($acao == "sair") {

    if (isset($_SESSION["usuario_id"])) {
        registrar_log($conn, (int) $_SESSION["usuario_id"], $_SESSION["login"], "LOGOUT");
    }

    session_destroy();

    header("Location: index.php?pagina=login&msg=sair");
    exit();
}

// daqui para baixo só entra quem estiver logado e já tiver trocado a senha
if (!isset($_SESSION["usuario_id"]) || $_SESSION["primeiro_acesso"] == 1) {
    header("Location: index.php");
    exit();
}


/*
   CONTINENTES
*/

if ($acao == "salvar_continente") {

    $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
    $populacao = mysqli_real_escape_string($conn, $_POST["populacao"]);
    $area = mysqli_real_escape_string($conn, $_POST["area"]);

    $sql = "INSERT INTO continentes (nome, populacao, area_km2)
            VALUES ('$nome', '$populacao', '$area')";

    mysqli_query($conn, $sql);

    header("Location: index.php?pagina=continentes");
    exit();
}

if ($acao == "excluir_continente") {

    $id = (int) $_GET["id"];

    // 🔥 remove dependências
    mysqli_query($conn, "DELETE FROM cidades WHERE pais_id IN (SELECT id FROM paises WHERE continente_id = $id)");
    mysqli_query($conn, "DELETE FROM paises WHERE continente_id = $id");

    // agora pode apagar continente
    mysqli_query($conn, "DELETE FROM continentes WHERE id = $id");

    header("Location: index.php?pagina=continentes");
    exit();
}


/*
   PAÍSES
*/

if ($acao == "salvar_pais") {

    $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
    $continente = mysqli_real_escape_string($conn, $_POST["continente"]);
    $populacao = mysqli_real_escape_string($conn, $_POST["populacao"]);
    $area = mysqli_real_escape_string($conn, $_POST["area"]);
    $idioma = mysqli_real_escape_string($conn, $_POST["idioma"]);
    $governante = mysqli_real_escape_string($conn, $_POST["governante"]);
    $clima = mysqli_real_escape_string($conn, $_POST["clima"]);
    $regime = mysqli_real_escape_string($conn, $_POST["regime"]);
    $moeda = mysqli_real_escape_string($conn, $_POST["moeda"]);

    $sql = "INSERT INTO paises
    (nome, continente_id, populacao, area_km2, idioma, governante_id, clima, regime_politico, moeda)
    VALUES
    ('$nome', '$continente', '$populacao', '$area', '$idioma', '$governante', '$clima', '$regime', '$moeda')";

    mysqli_query($conn, $sql);

    header("Location: index.php?pagina=paises");
    exit();
}

if ($acao == "excluir_pais") {

    $id = (int) $_GET["id"];

    // 🔥 remove cidades desse país
    mysqli_query($conn, "DELETE FROM cidades WHERE pais_id = $id");

    // agora remove o país
    mysqli_query($conn, "DELETE FROM paises WHERE id = $id");

    header("Location: index.php?pagina=paises");
    exit();
}


/*
   CIDADES
*/

if ($acao == "salvar_cidade") {

    $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
    $pais = mysqli_real_escape_string($conn, $_POST["pais"]);
    $populacao = mysqli_real_escape_string($conn, $_POST["populacao"]);
    $area = mysqli_real_escape_string($conn, $_POST["area"]);
    $clima = mysqli_real_escape_string($conn, $_POST["clima"]);
    $governante = mysqli_real_escape_string($conn, $_POST["governante"]);
    $fundacao = mysqli_real_escape_string($conn, $_POST["fundacao"]);

    $sql = "INSERT INTO cidades
    (nome, pais_id, populacao, area_km2, clima, governante_id, data_fundacao)
    VALUES
    ('$nome', '$pais', '$populacao', '$area', '$clima', '$governante', '$fundacao')";

    mysqli_query($conn, $sql);

    header("Location: index.php?pagina=cidades");
    exit();
}

if ($acao == "excluir_cidade") {

    $id = (int) $_GET["id"];

    mysqli_query($conn, "DELETE FROM cidades WHERE id = $id");

    header("Location: index.php?pagina=cidades");
    exit();
}


/*
   GOVERNANTES
*/

if ($acao == "salvar_governante") {

    $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
    $partido = mysqli_real_escape_string($conn, $_POST["partido"]);
    $nascimento = mysqli_real_escape_string($conn, $_POST["nascimento"]);
    $idade = mysqli_real_escape_string($conn, $_POST["idade"]);
    $inicio = mysqli_real_escape_string($conn, $_POST["inicio"]);
    $fim = mysqli_real_escape_string($conn, $_POST["fim"]);

    $sql = "INSERT INTO governantes
    (nome, partido_politico, data_nascimento, idade, inicio_mandato, fim_mandato)
    VALUES
    ('$nome', '$partido', '$nascimento', '$idade', '$inicio', '$fim')";

    mysqli_query($conn, $sql);

    header("Location: index.php?pagina=governantes");
    exit();
}

if ($acao == "excluir_governante") {

    $id = (int) $_GET["id"];

    // 🔥 limpa cidades
    mysqli_query($conn, "UPDATE cidades SET governante_id = NULL WHERE governante_id = $id");

    // 🔥 limpa países
    mysqli_query($conn, "UPDATE paises SET governante_id = NULL WHERE governante_id = $id");

    // agora pode apagar governante
    mysqli_query($conn, "DELETE FROM governantes WHERE id = $id");

    header("Location: index.php?pagina=governantes");
    exit();
}

?>