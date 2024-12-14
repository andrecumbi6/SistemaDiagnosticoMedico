<?php
    session_start();
    $login = $_SESSION['login'];
    $admin = $_SESSION['admin'];

    if ($login != "Confirmado") {
        header("Location: index.php");
    } else if ($admin === "user") {
        header("Location: sintomas.php");
    }  
?>

<!DOCTYPE html>
<html lang="pt-pt">
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
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        button {
            padding: 5px 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .delete {
            background-color: #FF0000;
        }
        .delete:hover {
            background-color: #cc0000;
        }
        .actions {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .actions button {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gerenciamento de Doenças</h1>
        <div class="actions">
            <button onclick="window.location.href='addDoencaFm.php'">Adicionar Doença</button>
            <button onclick="window.location.href='sintomas.php'">Fazer um Diagnóstico</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome da Doença</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Conexão com o banco de dados
                $host = "localhost";
                $usuario = "root";
                $senha = "";
                $banco = "diagnostico_medico";

                $conexao = new mysqli($host, $usuario, $senha, $banco);

                if ($conexao->connect_error) {
                    die("Erro de conexão: " . $conexao->connect_error);
                }

                // Consultar dados da tabela 'doencas'
                $sql = "SELECT * FROM doencas";
                $resultado = $conexao->query($sql);

                if ($resultado->num_rows > 0) {
                    while ($row = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['descricao']) . "</td>";
                        echo "<td>";
                        echo "<form style='display:inline;' action='editarDoenca.php' method='POST'>";
                        echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>";
                        echo "<button type='submit'>Editar</button>";
                        echo "</form>";
                        echo " ";
                        echo "<form style='display:inline;' action='eliminarDoenca.php' method='POST' onsubmit=\"return confirm('Tem certeza que deseja excluir esta entrada?');\">";
                        echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>";
                        echo "<button type='submit' class='delete'>Eliminar</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Nenhuma informação encontrada.</td></tr>";
                }

                $conexao->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
