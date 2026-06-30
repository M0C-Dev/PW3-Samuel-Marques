<?php
include("conexao.php");

$pagina = $_GET['pagina'] ?? "continentes";
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
            <div class="menu">
                <a href="?pagina=continentes">Continentes</a>
                <a href="?pagina=paises">Países</a>
                <a href="?pagina=cidades">Cidades</a>
                <a href="?pagina=governantes">Governantes</a>
            </div>
        </nav>
        <main>
            <?php if ($pagina == "continentes") { ?>
                <h2>Cadastro de Continentes</h2>
                <form action="crud.php" method="post">
                    <input type="hidden" name="acao" value="salvar_continente">
                    <label>Nome</label>
                    <input type="text" name="nome" required>
                    <label>População</label>
                    <input type="number" name="populacao">
                    <label>Área (km²)</label>
                    <input type="number" step="0.01" name="area">
                    <button type="submit">Salvar Continente</button>
                </form>
                <hr>
                <h2>Continentes Cadastrados</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>População</th>
                        <th>Área (km²)</th>
                        <th>Total de Países</th>
                        <th>Ações</th>
                    </tr>
                    <?php
                    $sql = "
    SELECT
        c.*,
        COUNT(p.id) AS total
    FROM continentes c
    LEFT JOIN paises p
        ON p.continente_id = c.id
    GROUP BY c.id
    ORDER BY c.nome
    ";
                    $resultado = mysqli_query($conn, $sql);
                    while ($linha = mysqli_fetch_assoc($resultado)) {
                        echo "
        <tr>
            <td>{$linha['id']}</td>
            <td>{$linha['nome']}</td>
            <td>{$linha['populacao']}</td>
            <td>{$linha['area_km2']}</td>
            <td>{$linha['total']}</td>
            <td>
                <a href='crud.php?acao=excluir_continente&id={$linha['id']}'
                onclick='return confirm(\"Deseja excluir este continente?\")'>
                    Excluir
                </a>
            </td>
        </tr>
        ";
                    }
                    ?>
                </table>
            <?php } ?>

            <?php if ($pagina == "paises") { ?>
                <h2>Cadastro de Países</h2>
                <form action="crud.php" method="post">
                    <input type="hidden" name="acao" value="salvar_pais">
                    <label>Nome</label>
                    <input type="text" name="nome" required>
                    <label>Continente</label>
                    <select name="continente" required>
                        <option value="">Selecione...</option>
                        <?php
                        $sql = "SELECT * FROM continentes ORDER BY nome";
                        $resultado = mysqli_query($conn, $sql);
                        while ($c = mysqli_fetch_assoc($resultado)) {
                            echo "<option value='{$c['id']}'>{$c['nome']}</option>";
                        }
                        ?>
                    </select>
                    <label>População</label>
                    <input type="number" name="populacao">
                    <label>Área (km²)</label>
                    <input type="number" step="0.01" name="area">
                    <label>Idioma</label>
                    <input type="text" name="idioma">
                    <label>Governante</label>
                    <select name="governante">
                        <option value="">Nenhum</option>
                        <?php
                        $sql = "SELECT * FROM governantes ORDER BY nome";
                        $resultado = mysqli_query($conn, $sql);
                        while ($g = mysqli_fetch_assoc($resultado)) {
                            echo "<option value='{$g['id']}'>{$g['nome']}</option>";
                        }
                        ?>
                    </select>
                    <label>Clima</label>
                    <input type="text" name="clima">
                    <label>Regime Político</label>
                    <input type="text" name="regime">
                    <label>Moeda</label>
                    <input type="text" name="moeda">
                    <button>Salvar País</button>
                </form>
                <hr>
                <h2>Países Cadastrados</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Continente</th>
                        <th>Governante</th>
                        <th>População</th>
                        <th>Ações</th>
                    </tr>
                    <?php
                    $sql = "
SELECT
p.*,
c.nome AS continente,
g.nome AS governante
FROM paises p
LEFT JOIN continentes c
ON c.id = p.continente_id
LEFT JOIN governantes g
ON g.id = p.governante_id
ORDER BY p.nome
";
                    $resultado = mysqli_query($conn, $sql);
                    while ($linha = mysqli_fetch_assoc($resultado)) {
                        echo "
<tr>
<td>{$linha['id']}</td>
<td>{$linha['nome']}</td>
<td>{$linha['continente']}</td>
<td>{$linha['governante']}</td>
<td>{$linha['populacao']}</td>
<td>
<a href='crud.php?acao=excluir_pais&id={$linha['id']}'
onclick='return confirm(\"Excluir país?\")'>
Excluir
</a>
</td>
</tr>
";
                    }
                    ?>
                </table>
            <?php } ?>

            <?php if ($pagina == "cidades") { ?>
                <h2>Cadastro de Cidades</h2>
                <form action="crud.php" method="post">
                    <input type="hidden" name="acao" value="salvar_cidade">
                    <label>Nome</label>
                    <input type="text" name="nome" required>
                    <label>País</label>
                    <select name="pais" required>
                        <option value="">Selecione...</option>
                        <?php
                        $sql = "SELECT * FROM paises ORDER BY nome";
                        $resultado = mysqli_query($conn, $sql);
                        while ($pais = mysqli_fetch_assoc($resultado)) {
                            echo "<option value='{$pais['id']}'>{$pais['nome']}</option>";

                        }
                        ?>
                    </select>
                    <label>População</label>
                    <input type="number" name="populacao">
                    <label>Área (km²)</label>
                    <input type="number" step="0.01" name="area">
                    <label>Clima</label>
                    <input type="text" name="clima">
                    <label>Governante</label>
                    <select name="governante">
                        <option value="">Nenhum</option>
                        <?php
                        $sql = "SELECT * FROM governantes ORDER BY nome";
                        $resultado = mysqli_query($conn, $sql);
                        while ($g = mysqli_fetch_assoc($resultado)) {
                            echo "<option value='{$g['id']}'>{$g['nome']}</option>";
                        }
                        ?>
                    </select>
                    <label>Data de Fundação</label>
                    <input type="date" name="fundacao">
                    <button>Salvar Cidade</button>
                </form>
                <hr>
                <h2>Cidades Cadastradas</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>País</th>
                        <th>Governante</th>
                        <th>População</th>
                        <th>Ações</th>
                    </tr>
                    <?php
                    $sql = "
SELECT
c.*,
p.nome AS pais,
g.nome AS governante
FROM cidades c
LEFT JOIN paises p
ON p.id = c.pais_id
LEFT JOIN governantes g
ON g.id = c.governante_id
ORDER BY c.nome
";
                    $resultado = mysqli_query($conn, $sql);
                    while ($linha = mysqli_fetch_assoc($resultado)) {
                        echo "
<tr>
<td>{$linha['id']}</td>
<td>{$linha['nome']}</td>
<td>{$linha['pais']}</td>
<td>{$linha['governante']}</td>
<td>{$linha['populacao']}</td>
<td>
<a href='crud.php?acao=excluir_cidade&id={$linha['id']}'
onclick='return confirm(\"Excluir cidade?\")'>
Excluir
</a>
</td>
</tr>
";
                    }
                    ?>
                </table>
            <?php } ?>

            <?php if ($pagina == "governantes") { ?>
                <h2>Cadastro de Governantes</h2>
                <form action="crud.php" method="post">
                    <input type="hidden" name="acao" value="salvar_governante">
                    <label>Nome</label>
                    <input type="text" name="nome" required>
                    <label>Partido Político</label>
                    <input type="text" name="partido">
                    <label>Data de Nascimento</label>
                    <input type="date" name="nascimento">
                    <label>Idade</label>
                    <input type="number" name="idade">
                    <label>Início do Mandato</label>
                    <input type="date" name="inicio">
                    <label>Fim do Mandato</label>
                    <input type="date" name="fim">
                    <button type="submit">Salvar Governante</button>
                </form>
                <hr>
                <h2>Governantes Cadastrados</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Partido</th>
                        <th>Idade</th>
                        <th>Início</th>
                        <th>Fim</th>
                        <th>Ações</th>
                    </tr>
                    <?php
                    $sql = "SELECT * FROM governantes ORDER BY nome";
                    $resultado = mysqli_query($conn, $sql);
                    while ($linha = mysqli_fetch_assoc($resultado)) {
                        echo "
<tr>
<td>{$linha['id']}</td>
<td>{$linha['nome']}</td>
<td>{$linha['partido_politico']}</td>
<td>{$linha['idade']}</td>
<td>{$linha['inicio_mandato']}</td>
<td>{$linha['fim_mandato']}</td>
<td>
<a href='crud.php?acao=excluir_governante&id={$linha['id']}'
onclick='return confirm(\"Excluir governante?\")'>
Excluir
</a>
</td>
</tr>
";
                    }
                    ?>
                </table>
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