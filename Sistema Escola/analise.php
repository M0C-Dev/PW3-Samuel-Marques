<?php
if (
    !isset($_POST['turma']) ||
    !isset($_POST['quantidade'])
) {
    header("Location: index.html");
    exit();
}

$turmaNome = $_POST['turma'];
$quantidadeAlunosSala = $_POST['quantidade'];

$nomes = $_POST['alunoNome'];
$n1 = $_POST['alunoN1'];
$n2 = $_POST['alunoN2'];
$t1 = $_POST['alunoT1'];

$alunos = [];

// Fazendo os aluno com as coisa tudo

for ($i = 0; $i < count($nomes); $i++) {

    $mediaAritimetica = ($n1[$i] + $n2[$i] + $t1[$i]) / 3;
    $raizQuadradaSoma = sqrt($n1[$i] + $n2[$i] + $t1[$i]);
    $diferencaAbsoluta = max($n1[$i], $n2[$i], $t1[$i]) - min($n1[$i], $n2[$i], $t1[$i]);

    if ($mediaAritimetica >= 7) {
        $situacao = "Aprovado";
    } else if ($mediaAritimetica >= 5) {
        $situacao = "Recuperacao";
    } else {
        $situacao = "Reprovado";
    }

    $alunos[] = [
        "nome" => $nomes[$i],
        "n1" => $n1[$i],
        "n2" => $n2[$i],
        "t1" => $t1[$i],
        "mediaAritimetica" => $mediaAritimetica,
        "raizQuadradaSoma" => $raizQuadradaSoma,
        "diferencaAbsoluta" => $diferencaAbsoluta,
        "situacao" => $situacao
    ];
}

// Fazendo as coisa da sala no geral

        // Media geral
        $somaMedias = 0;
        foreach ($alunos as $aluno) {
            $somaMedias += $aluno['mediaAritimetica'];
        }
        $mediaGeralTurma = $somaMedias / count($alunos);

        // Maior e menor media
        $maiorMedia = $alunos[0]['mediaAritimetica'];
        foreach ($alunos as $aluno) {
            if ($aluno['mediaAritimetica'] > $maiorMedia) {
                $maiorMedia = $aluno['mediaAritimetica'];
            }
        }

        $menorMedia = $alunos[0]['mediaAritimetica'];
        foreach ($alunos as $aluno) {
            if ($aluno['mediaAritimetica'] < $menorMedia) {
                $menorMedia = $aluno['mediaAritimetica'];
            }
        }

        // Aprovados reprovados e recuperação
        $aprovados = 0;
        $recuperacao = 0;
        $reprovados = 0;
        foreach ($alunos as $aluno) {
            if ($aluno['situacao'] == "Aprovado") {
                $aprovados++;
            } else if ($aluno['situacao'] == "Recuperacao") {
                $recuperacao++;
            } else if ($aluno['situacao'] == "Reprovado") {
                $reprovados++;
            }
        }

        //percentual de aprovação
        $totalAlunos = count($alunos);
        $percentualAprovacao = ($aprovados / $totalAlunos) * 100;

        // Soma total de todaaas as notas
        $somaTotalNotas = 0;
        foreach ($alunos as $aluno) {
            $somaTotalNotas += $aluno['n1'];
            $somaTotalNotas += $aluno['n2'];
            $somaTotalNotas += $aluno['t1'];
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
            <fieldset>
                <legend>Estatisticas da Turma</legend>
                <br>
                <span>Nome da Turma... <b><?php echo $turmaNome ?></b></span><br>
                <span>Quantidade de Alunos... <b><?php echo $quantidadeAlunosSala ?></b></span><br><br>
                <span>Média Geral da Turma... <b><?php echo number_format($mediaGeralTurma, 2) ?></b></span><br>
                <span>Maior Média... <b><?php echo number_format($maiorMedia, 2) ?></b></span><br>
                <span>Menor Média... <b><?php echo number_format($menorMedia, 2) ?></b></span><br><br>
                <span>Aprovados... <b><?php echo $aprovados ?></b></span><br>
                <span>Recuperação... <b><?php echo $recuperacao ?></b></span><br>
                <span>Reprovados... <b><?php echo $reprovados ?></b></span><br>
                <span>Percentual de Aprovação... <b><?php echo number_format($percentualAprovacao, 2) ?>%</b></span><br><br>
                <span>Soma Total das Notas... <b><?php echo $somaTotalNotas ?></b></span><br><br>
            </fieldset>
            <fieldset>
                <legend>Alunos da Turma</legend>
                <table>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>N1</th>
                        <th>N2</th>
                        <th>T1</th>
                        <th>Média</th>
                        <th>Situação</th>
                        <th>Diferença</th>
                    </tr>
                    <?php foreach ($alunos as $i => $aluno): ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><?php echo $aluno['nome']; ?></td>
                            <td><?php echo $aluno['n1']; ?></td>
                            <td><?php echo $aluno['n2']; ?></td>
                            <td><?php echo $aluno['t1']; ?></td>
                            <td><?php echo number_format($aluno['mediaAritimetica'], 2); ?></td>
                            <td><?php echo $aluno['situacao']; ?></td>
                            <td><?php echo number_format($aluno['diferencaAbsoluta'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </fieldset>
        </main>
        <footer>
            <hr>
            <p>Por Samuel M. 2026 ©</p>
            <hr>
        </footer>
    </div>
</body>
</html>