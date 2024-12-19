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

// Atualizando as informações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $bio = $_POST['bio']; // Captura da bio

    // Atualizando o banco de dados
    $stmt = $pdo->prepare('UPDATE users SET username = ?, email = ?, bio = ? WHERE id = ?');
    $stmt->execute([$username, $email, $bio, $_SESSION['user_id']]);

    header('Location: perfil.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="home.php">Home</a>
        <a href="perfil.php">Perfil</a>
        <a href="editar_perfil.php">Editar Perfil</a>
    </nav>
    <div class="container">
        <div class="edit-profile-box">
            <h1>Editar Perfil</h1>
            <form action="editar_perfil.php" method="POST">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                <label for="bio">Bio:</label>
                <textarea id="bio" name="bio" required><?php echo htmlspecialchars($user['bio']); ?></textarea> <!-- Campo para editar a bio -->
                <button type="submit">Salvar Alterações</button>
            </form>
        </div>
    </div>
</body>
</html>
