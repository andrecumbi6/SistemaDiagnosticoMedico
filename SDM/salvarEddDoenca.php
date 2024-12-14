<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
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
    $id = intval($_POST['id']);
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $tratamento = trim($_POST['tratamento']);
    $sintomasSelecionados = isset($_POST['sintomas']) ? $_POST['sintomas'] : [];

    // Iniciar transação para garantir consistência
    $conexao->begin_transaction();

    try {
        // Atualizar os dados da doença
        $sqlDoenca = "UPDATE doencas SET nome = ?, descricao = ? WHERE id = ?";
        $stmtDoenca = $conexao->prepare($sqlDoenca);
        $stmtDoenca->bind_param("ssi", $nome, $descricao, $id);
        $stmtDoenca->execute();

        // Atualizar o tratamento
        $sqlTratamento = "UPDATE tratamentos SET descricao = ? WHERE doenca_id = ?";
        $stmtTratamento = $conexao->prepare($sqlTratamento);
        $stmtTratamento->bind_param("si", $tratamento, $id);
        $stmtTratamento->execute();

        // Atualizar os sintomas associados
        // 1. Remover todos os sintomas atuais
        $sqlRemoveSintomas = "DELETE FROM doencas_sintomas WHERE doenca_id = ?";
        $stmtRemoveSintomas = $conexao->prepare($sqlRemoveSintomas);
        $stmtRemoveSintomas->bind_param("i", $id);
        $stmtRemoveSintomas->execute();

        // 2. Adicionar os novos sintomas selecionados
        $sqlAddSintomas = "INSERT INTO doencas_sintomas (doenca_id, sintoma_id) VALUES (?, ?)";
        $stmtAddSintomas = $conexao->prepare($sqlAddSintomas);
        foreach ($sintomasSelecionados as $sintomaId) {
            $sintomaId = intval($sintomaId);
            $stmtAddSintomas->bind_param("ii", $id, $sintomaId);
            $stmtAddSintomas->execute();
        }

        // Confirmar a transação
        $conexao->commit();
        echo "Dados atualizados com sucesso!";
        header("Location: visualizarDoenca.php");
        exit;

    } catch (Exception $e) {
        // Reverter a transação em caso de erro
        $conexao->rollback();
        echo "Erro ao atualizar dados: " . $e->getMessage();
    }

    $conexao->close();
} else {
    echo "Requisição inválida.";
}
?>
