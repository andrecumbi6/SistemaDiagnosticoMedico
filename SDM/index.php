<?php
// Página HTML/PHP para Login
session_start();
$_SESSION['login'] = 'Nao Confirmado';
?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="ALC">
    <title>Sistema de Diagnóstico Médico</title>
    <link href="css/style.css" rel="stylesheet">

    <script>
        function showLoading() {
            const loadingScreen = document.querySelector(".loading");
            loadingScreen.style.display = "flex";
            setTimeout(() => {
                document.getElementById("login-form").submit();
            }, 5000);
        }
    </script>
</head>
<body>
    <div class="loading" style="display: none;">Processando...</div>
    <div class="login-container">
        <h1>Login</h1>
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">' . htmlspecialchars($_GET['error']) . '</p>';
        }
        ?>
        <form id="login-form" action="autenticacao.php" method="POST" onsubmit="showLoading(); return false;">
            <input type="text" name="username" placeholder="Usuário" required>
            <input type="password" name="password" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
