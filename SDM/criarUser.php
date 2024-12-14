<?php
// Configuração do banco de dados
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "diagnostico_medico";

// Conexão com o banco de dados
$conexao = new mysqli($host, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
}

// Dados do usuário
$username = "admin"; // Substitua pelo nome de usuário desejado
$password = "111111"; // Substitua pela senha desejada

// Gerar o hash da senha
$hash = password_hash($password, PASSWORD_BCRYPT);

// Inserir o usuário no banco de dados
$sql = $conexao->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
$sql->bind_param("ss", $username, $hash);

if ($sql->execute()) {
    echo "Usuário criado com sucesso!";
} else {
    echo "Erro ao criar usuário: " . $conexao->error;
}

$conexao->close();
?>
