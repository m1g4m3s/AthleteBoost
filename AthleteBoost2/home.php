<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="home.php">Home</a>
        <a href="perfil.php">Perfil</a>
        <a href="editar_perfil.php">Editar Perfil</a>
        <a href="tecnicas.php">Técnicas</a>
        <a href="treinos.php">Treinos</a>
        <a href="criar_ficha.php">Criar Fichas</a>
    </nav>
    <div class="container">
        <div class="home-message-box">
            <h1>Bem-vindo à Página Inicial!</h1>
            <p>Você está logado com sucesso. Aproveite para explorar as técnicas, treinos e editar seu perfil!</p>
            <a href="logout.php" class="logout-button">Sair</a>
        </div>
    </div>
</body>
</html>
