<?php

session_start();

// Conteúdo do arquivo de autenticacao
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Conectar a base de dados
    $host = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "diagnostico_medico";

    $conexao = new mysqli($host, $usuario, $senha, $banco);

    if ($conexao->connect_error) {
        die("Erro de conexão: " . $conexao->connect_error);
    }

    // Consultar o usuário na base de dados
    $sql = $conexao->prepare("SELECT password FROM usuarios WHERE username = ?");
    $sql->bind_param("s", $username);
    $sql->execute();
    $resultado = $sql->get_result();

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();

        // Verificar senha
        if (password_verify($password, $row['password'])) {
            // Login bem-sucedido
            $_SESSION['login'] = 'Confirmado';

            if ($username === "admin") {
                $_SESSION['admin'] = 'admin';
                header("Location: visualizarDoenca.php");
            } else {
                $_SESSION['admin'] = 'user';
                header("Location: sintomas.php");
            }

        } else {
            header("Location: index.php?error=Senha incorreta");
        }
    } else {
        header("Location: index.php?error=Usuário não encontrado");
    }

    $conexao->close();
}
?>
