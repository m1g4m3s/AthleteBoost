// add_treino.php
<?php
session_start();

if ($_SESSION['user_id'] !== 'admin') {
    header('Location: index.html');
    exit;
}

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $video_url = $_POST['video_url'];

    $stmt = $pdo->prepare('INSERT INTO treinos (titulo, descricao, video_url) VALUES (?, ?, ?)');
    $stmt->execute([$titulo, $descricao, $video_url]);

    header('Location: admin_panel.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Treino</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <a href="admin_panel.php">Painel Administrativo</a>
    <a href="logout.php">Sair</a>
</nav>

<div class="container">
    <h1>Adicionar Novo Treino</h1>
    <form action="add_treino.php" method="POST">
        <input type="text" name="titulo" placeholder="Título" required>
        <textarea name="descricao" placeholder="Descrição" required></textarea>
        <input type="text" name="video_url" placeholder="URL do Vídeo" required>
        <button type="submit">Adicionar Treino</button>
    </form>
</div>

</body>
</html>
