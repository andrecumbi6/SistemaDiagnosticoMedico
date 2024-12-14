<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Conexão com a base de dados
    $host = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "diagnostico_medico";

    $conexao = new mysqli($host, $usuario, $senha, $banco);
    if ($conexao->connect_error) {
        die("Erro de conexão: " . $conexao->connect_error);
    }

    // Iniciar uma transação para garantir consistência
    $conexao->begin_transaction();

    try {
        // Excluir o tratamento associado à doença
        $sqlTratamento = "DELETE FROM tratamentos WHERE doenca_id = ?";
        $stmtTratamento = $conexao->prepare($sqlTratamento);
        $stmtTratamento->bind_param("i", $id);
        $stmtTratamento->execute();

        // Excluir os relacionamentos da doença com os sintomas
        //$sqlRelacionamentos = "DELETE FROM doencas_sintomas WHERE doenca_id = ?";
        //$stmtRelacionamentos = $conexao->prepare($sqlRelacionamentos);
        //$stmtRelacionamentos->bind_param("i", $id);
        //$stmtRelacionamentos->execute();

        // Excluir a doença
        $sqlDoenca = "DELETE FROM doencas WHERE id = ?";
        $stmtDoenca = $conexao->prepare($sqlDoenca);
        $stmtDoenca->bind_param("i", $id);
        $stmtDoenca->execute();

        // Confirmar as alterações
        $conexao->commit();

        echo "Doença e tratamento excluídos com sucesso!";
        header("Location: visualizarDoenca.php");
        exit;

    } catch (Exception $e) {
        // Reverter alterações em caso de erro
        $conexao->rollback();
        die("Erro ao excluir dados: " . $e->getMessage());
    } finally {
        $stmtTratamento->close();
        $stmtRelacionamentos->close();
        $stmtDoenca->close();
        $conexao->close();
    }
}
?>
