<?php
if (
    !isset($_POST['alunoNome']) ||
    !isset($_POST['alunoN1']) ||
    !isset($_POST['alunoN2']) ||
    !isset($_POST['alunoT1'])
) {
    header("Location: index.html");
    exit();
}

$nomes = $_POST['alunoNome'];
$n1 = $_POST['alunoN1'];
$n2 = $_POST['alunoN2'];
$t1 = $_POST['alunoT1'];

$alunos = [];

for ($i = 0; $i < count($nomes); $i++) {

    $alunos[] = [
        "nome" => $nomes[$i],
        "n1" => $n1[$i],
        "n2" => $n2[$i],
        "t1" => $t1[$i]
    ];

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Escolar TWISTER</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="container">
        <header>
            <img src="imgs/rato-logos.png" alt="">
            <span id="logo">Sistema Escolar TWISTER</span>
        </header>
        <nav>
            <span class="miniTitle">Conclusão: Relatório Completo</span>
        </nav>
        <main>

        </main>
        <footer>
            <hr>
            <p>Por Samuel M. 2026 ©</p>
            <hr>
        </footer>
    </div>
</body>
</html>