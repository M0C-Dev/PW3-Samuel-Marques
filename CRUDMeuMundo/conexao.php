<?php

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "bd_mundo";

$conn = mysqli_connect($host, $usuario, $senha, $banco);

if (!$conn) {
    die("Erro na conexão: " . mysqli_connect_error());
}
?>