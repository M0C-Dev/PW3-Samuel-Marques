<?php

include("conexao.php");

$acao = $_REQUEST["acao"] ?? "";

/*
   CONTINENTES
*/

if ($acao == "salvar_continente") {

    $nome = $_POST["nome"];
    $populacao = $_POST["populacao"];
    $area = $_POST["area"];

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

    $nome = $_POST["nome"];
    $continente = $_POST["continente"];
    $populacao = $_POST["populacao"];
    $area = $_POST["area"];
    $idioma = $_POST["idioma"];
    $governante = $_POST["governante"];
    $clima = $_POST["clima"];
    $regime = $_POST["regime"];
    $moeda = $_POST["moeda"];

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

    $nome = $_POST["nome"];
    $pais = $_POST["pais"];
    $populacao = $_POST["populacao"];
    $area = $_POST["area"];
    $clima = $_POST["clima"];
    $governante = $_POST["governante"];
    $fundacao = $_POST["fundacao"];

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

    $nome = $_POST["nome"];
    $partido = $_POST["partido"];
    $nascimento = $_POST["nascimento"];
    $idade = $_POST["idade"];
    $inicio = $_POST["inicio"];
    $fim = $_POST["fim"];

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