<?php
// Verificando se o usuário está logado
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}

// Conexão com o banco de dados
require 'db.php';
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Perfil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="home.php">Home</a>
        <a href="perfil.php">Perfil</a>
        <a href="editar_perfil.php">Editar Perfil</a>
    </nav>
    <div class="container">
        <div class="profile-box">
            <h1>Seu Perfil</h1>
            <div class="profile-details">
                <label for="username">Usuário:</label>
                <span><?php echo htmlspecialchars($user['username']); ?></span>
                <label for="email">E-mail:</label>
                <span><?php echo htmlspecialchars($user['email']); ?></span>
                <label for="bio">Bio:</label>
                <span><?php echo nl2br(htmlspecialchars($user['bio'])); ?></span>
                <!-- Você pode adicionar mais detalhes aqui -->
            </div>
        </div>
    </div>
</body>
</html>
