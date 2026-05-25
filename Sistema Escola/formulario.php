<?php

if (isset($_POST['turma']) && isset($_POST['quantidade'])) {
    $turma = $_POST['turma'];
    $quantidade = $_POST['quantidade'];
} else if (empty($_POST)) {
    header("Location: index.html");
    exit();
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
            <span class="miniTitle">Segunda Etapa: Informação dos Alunos</span>
        </nav>
        <main>
            <fieldset>
                    <legend>Sobre a sala</legend>
                    <br>
                    <span>Nome da Turma...<b><?php echo $turma ?></b></span><br><br>

                    <span>Quantidade de Alunos...<b><?php echo $quantidade ?></b></span>
                    <br><br>
            </fieldset>
            <form action="analise.php" method="POST">
                <input type="hidden" name="turma" value="<?php echo $turma; ?>">
                <input type="hidden" name="quantidade" value="<?php echo $quantidade; ?>">
                
                <table border="1">

                    <colgroup>
                        <col style="width: 5%;">
                        <col style="width: 35%;">
                        <col style="width: 20%;">
                        <col style="width: 20%;">
                        <col style="width: 20%;">
                    </colgroup>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>N1</th>
                        <th>N2</th>
                        <th>T1</th>
                    </tr>
                    <?php for ($i = 1; $i <= $quantidade; $i++): ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <input type="text" name="alunoNome[]" placeholder="Nome do aluno" required>
                            </td>
                            <td>
                                <input type="number" name="alunoN1[]" step="0.1" min="0" max="10" required>
                            </td>
                            <td>
                                <input type="number" name="alunoN2[]" step="0.1" min="0" max="10" required>
                            </td>
                            <td>
                                <input type="number" name="alunoT1[]" step="0.1" min="0" max="10" required>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </table>

                <br><br>
                <button type="submit" class="submitButton">Continuar</button>
                <br><br>
                <a href="index.html" class="voltar">Voltar</a>
            </form>
        </main>
        <footer>
            <hr>
            <p>Por Samuel M. 2026 ©</p>
            <hr>
        </footer>
    </div>
</body>
</html>