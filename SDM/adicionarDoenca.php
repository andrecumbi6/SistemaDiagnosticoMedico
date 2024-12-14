<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexão com o banco de dados
    $host = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "diagnostico_medico";

    $conexao = new mysqli($host, $usuario, $senha, $banco);
    if ($conexao->connect_error) {
        die("Erro de conexão: " . $conexao->connect_error);
    }

    // Receber os dados do formulário
    $doenca = $_POST['doenca'];
    $descricao = $_POST['descricao'];
    $sintomas = explode(',', $_POST['sintomas']);
    $tratamento = $_POST['tratamento'];

    // Inserir a doença
    $stmtDoenca = $conexao->prepare("INSERT INTO doencas (nome, descricao) VALUES (?, ?)");
    $stmtDoenca->bind_param("ss", $doenca, $descricao);
    if (!$stmtDoenca->execute()) {
        die("Erro ao inserir doença: " . $conexao->error);
    }
    $doencaId = $stmtDoenca->insert_id;

    // Inserir os sintomas
    foreach ($sintomas as $sintoma) {
        $sintoma = trim($sintoma);

        // Verificar se o sintoma já existe
        $stmtCheckSintoma = $conexao->prepare("SELECT id FROM sintomas WHERE nome = ?");
        $stmtCheckSintoma->bind_param("s", $sintoma);
        $stmtCheckSintoma->execute();
        $resultadoSintoma = $stmtCheckSintoma->get_result();

        if ($resultadoSintoma->num_rows > 0) {
            $sintomaId = $resultadoSintoma->fetch_assoc()['id'];
        } else {
            // Inserir novo sintoma
            $stmtSintoma = $conexao->prepare("INSERT INTO sintomas (nome) VALUES (?)");
            $stmtSintoma->bind_param("s", $sintoma);
            if (!$stmtSintoma->execute()) {
                die("Erro ao inserir sintoma: " . $conexao->error);
            }
            $sintomaId = $stmtSintoma->insert_id;
        }

        // Relacionar o sintoma com a doença
        $stmtDoencaSintoma = $conexao->prepare("INSERT INTO doencas_sintomas (doenca_id, sintoma_id) VALUES (?, ?)");
        $stmtDoencaSintoma->bind_param("ii", $doencaId, $sintomaId);
        if (!$stmtDoencaSintoma->execute()) {
            die("Erro ao relacionar sintoma: " . $conexao->error);
        }
    }

    // Inserir o tratamento
    $stmtTratamento = $conexao->prepare("INSERT INTO tratamentos (doenca_id, descricao) VALUES (?, ?)");
    $stmtTratamento->bind_param("is", $doencaId, $tratamento);
    if (!$stmtTratamento->execute()) {
        die("Erro ao inserir tratamento: " . $conexao->error);
    }

    echo "Dados adicionados com sucesso!";
    header("Location: visualizarDoenca.php");
    $conexao->close();
}
?>
