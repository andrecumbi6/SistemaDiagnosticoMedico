<?php
    session_start();
    $login = $_SESSION['login'];

    if ($login != "Confirmado") {
        header("Location: index.php");
    }

// Verificar se os sintomas foram enviados da pagina anterior
if (isset($_POST['sintomas']) && is_array($_POST['sintomas'])) {
    $sintomasSelecionados = $_POST['sintomas'];

    // Verificar se pelo menos dois sintomas foram selecionados
    if (count($sintomasSelecionados) < 2) {
        echo "<h1 style=\"color: #007BFF; padding-left: 30%; padding-top: 50px;\">Erro...</h1>";
        echo "<h3 style=\"padding-left: 30%;\">Selecione pelo menos dois sintomas para continuar.</h3>";
        exit;
    }

    // Conexão com a base de dados
    $host = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "diagnostico_medico";

    $conexao = new mysqli($host, $usuario, $senha, $banco);

    if ($conexao->connect_error) {
        die("Falha na conexão: " . $conexao->connect_error);
    }

    // Montar a consulta para buscar doenças relacionadas aos sintomas selecionados
    $sintomasIds = implode(",", array_map('intval', $sintomasSelecionados));

    $sql = "
        SELECT DISTINCT d.nome AS doenca, d.descricao AS descricao_doenca, t.descricao AS tratamento
        FROM doencas d
        JOIN doencas_sintomas ds ON d.id = ds.doenca_id
        JOIN sintomas s ON s.id = ds.sintoma_id
        LEFT JOIN tratamentos t ON d.id = t.doenca_id
        WHERE s.id IN ($sintomasIds)
        GROUP BY d.id
        HAVING COUNT(DISTINCT s.id) >= 2
    ";

    $resultado = $conexao->query($sql);
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="ALC">
    <title>Sistema de Diagnóstico Médico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        h1, h2 {
            color: #007BFF;
        }
        .result {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .result h2 {
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resultados do Diagnóstico</h1>
        <h3>Sintomas Selecionados:</h3>
        <ul>
            <?php
            // Exibir os sintomas selecionados
            $sqlSintomas = "SELECT nome FROM sintomas WHERE id IN ($sintomasIds)";
            $resultadoSintomas = $conexao->query($sqlSintomas);

            if ($resultadoSintomas->num_rows > 0) {
                while ($sintoma = $resultadoSintomas->fetch_assoc()) {
                    echo "<li>" . htmlspecialchars($sintoma['nome']) . "</li>";
                }
            }
            ?>
        </ul>

        <?php
        // Exibir os resultados do diagnóstico
        if ($resultado->num_rows > 0) {
            while ($linha = $resultado->fetch_assoc()) {
                $doenca = htmlspecialchars($linha['doenca']);
                $descricao = htmlspecialchars($linha['descricao_doenca']);
                $tratamento = htmlspecialchars($linha['tratamento']);
                ?>
                <div class="result">
                    <h2>Doença: <?php echo $doenca; ?></h2>
                    <p><strong>Descrição:</strong> <?php echo $descricao; ?></p>
                    <p><strong>Tratamento:</strong> <?php echo $tratamento ? $tratamento : "Não disponível"; ?></p>
                </div>
                <?php
            }
        } else {
            echo "<p>Nenhuma doença encontrada para os sintomas selecionados.</p>";
        }

        $conexao->close();
        ?>

<?php
} else {
?>
    <h1 style="color: #007BFF; padding-left: 30%; padding-top: 50px;" >Erro...</h1>
    <h3 style="padding-left: 30%;">Nenhum sintoma foi selecionado.</h3>

<?php
}
?>
    </div>
</body>
</html>
