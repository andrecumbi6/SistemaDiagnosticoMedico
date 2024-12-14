<?php

session_start();
$login = $_SESSION['login'];
$admin = $_SESSION['admin'];

if ($login != "Confirmado") {
    header("Location: index.php");
} else if ($admin === "user") {
    header("Location: sintomas.php");
}  

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Conexão com o banco de dados
    $host = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "diagnostico_medico";

    $conexao = new mysqli($host, $usuario, $senha, $banco);
    if ($conexao->connect_error) {
        die("Erro de conexão: " . $conexao->connect_error);
    }

    // Buscar os dados da doença
    $sqlDoenca = "SELECT * FROM doencas WHERE id = ?";
    $stmtDoenca = $conexao->prepare($sqlDoenca);
    $stmtDoenca->bind_param("i", $id);
    $stmtDoenca->execute();
    $doenca = $stmtDoenca->get_result()->fetch_assoc();

    // Buscar os sintomas associados à doença
    $sqlSintomas = "SELECT s.id, s.nome FROM sintomas s JOIN doencas_sintomas ds ON s.id = ds.sintoma_id WHERE ds.doenca_id = ?";
    $stmtSintomas = $conexao->prepare($sqlSintomas);
    $stmtSintomas->bind_param("i", $id);
    $stmtSintomas->execute();
    $sintomasAssociados = $stmtSintomas->get_result();

    // Buscar todos os sintomas disponíveis
    $sqlTodosSintomas = "SELECT id, nome FROM sintomas";
    $resultadoTodosSintomas = $conexao->query($sqlTodosSintomas);

    // Buscar o tratamento associado à doença
    $sqlTratamento = "SELECT descricao FROM tratamentos WHERE doenca_id = ?";
    $stmtTratamento = $conexao->prepare($sqlTratamento);
    $stmtTratamento->bind_param("i", $id);
    $stmtTratamento->execute();
    $tratamento = $stmtTratamento->get_result()->fetch_assoc();
}
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
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #007BFF;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Doença</h1>
        <form action="salvarEddDoenca.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $doenca['id']; ?>">
            
            <label for="nome">Nome da Doença:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($doenca['nome']); ?>" required>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="3" required><?php echo htmlspecialchars($doenca['descricao']); ?></textarea>

            <label for="sintomas">Sintomas (Selecione múltiplos):</label>
            <select id="sintomas" name="sintomas[]" multiple required>
                <?php
                // Exibir todos os sintomas com os já associados marcados
                $sintomasSelecionados = [];
                while ($sintoma = $sintomasAssociados->fetch_assoc()) {
                    $sintomasSelecionados[] = $sintoma['id'];
                }

                while ($sintoma = $resultadoTodosSintomas->fetch_assoc()) {
                    $selected = in_array($sintoma['id'], $sintomasSelecionados) ? "selected" : "";
                    echo "<option value='{$sintoma['id']}' $selected>" . htmlspecialchars($sintoma['nome']) . "</option>";
                }
                ?>
            </select>

            <label for="tratamento">Tratamento:</label>
            <textarea id="tratamento" name="tratamento" rows="3" required><?php echo htmlspecialchars($tratamento['descricao']); ?></textarea>

            <button type="submit">Salvar</button>
        </form>
    </div>
</body>
</html>
