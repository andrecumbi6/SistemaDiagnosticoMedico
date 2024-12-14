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
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #007BFF;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
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
        <h1>Adicionar Doença</h1>
        <form action="adicionarDoenca.php" method="POST">
            <div class="form-group">
                <label for="doenca">Nome da Doença:</label>
                <input type="text" id="doenca" name="doenca" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição da Doença:</label>
                <textarea id="descricao" name="descricao" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="sintomas">Sintomas (separados por vírgula):</label>
                <input type="text" id="sintomas" name="sintomas" required>
            </div>
            <div class="form-group">
                <label for="tratamento">Descrição do Tratamento:</label>
                <textarea id="tratamento" name="tratamento" rows="3" required></textarea>
            </div>
            <button type="submit">Adicionar Dados</button>
        </form>
    </div>
</body>
</html>
