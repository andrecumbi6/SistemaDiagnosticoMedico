<?php
    session_start();
    $login = $_SESSION['login'];

    if ($login != "Confirmado") {
        header("Location: index.php");
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
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            color: #007BFF;
            font-weight: bold;
        }
    </style>
    <script>
        function showLoading() {
            const loadingScreen = document.querySelector(".loading");
            loadingScreen.style.display = "flex";
            setTimeout(() => {
                document.getElementById("sintomas-form").submit();
            }, 5000);
        }
    </script>
</head>
<body>
    <div class="loading">Processando...</div>
    <div class="container">
        <h1>Selecione os Sintomas</h1>
        <form id="sintomas-form" action="resultado.php" method="POST" onsubmit="showLoading(); return false;">
            <div class="form-group">
                <label for="sintomas">Sintomas Disponíveis:</label>
                <br>
                <?php
                // Conexão com o banco de dados
                $host = "localhost";
                $usuario = "root";
                $senha = "";
                $banco = "diagnostico_medico";

                $conexao = new mysqli($host, $usuario, $senha, $banco);

                if ($conexao->connect_error) {
                    die("Falha na conexão: " . $conexao->connect_error);
                }

                // Buscar sintomas únicos na base de dados
                $sql = "SELECT id, nome FROM sintomas ORDER BY nome";
                $resultado = $conexao->query($sql);

                if ($resultado->num_rows > 0) {
                    while ($linha = $resultado->fetch_assoc()) {
                        $sintomaId = $linha['id'];
                        $sintomaNome = htmlspecialchars($linha['nome']);
                        echo "<div><input type='checkbox' name='sintomas[]' value='$sintomaId'> $sintomaNome</div>";
                    }
                } else {
                    echo "Nenhum sintoma encontrado na base de dados.";
                }

                $conexao->close();
                ?>
            </div>
            <button type="submit">Buscar Diagnóstico</button>
        </form>
    </div>
</body>
</html>
