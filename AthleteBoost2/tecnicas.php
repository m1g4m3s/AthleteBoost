<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}

// Conexão com o banco de dados
require 'db.php';

// Buscar as técnicas cadastradas no banco de dados
$query = "SELECT * FROM tecnicas";
$stmt = $pdo->prepare($query);
$stmt->execute();
$tecnicas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Técnicas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="home.php">Home</a>
        <a href="perfil.php">Perfil</a>
        <a href="editar_perfil.php">Editar Perfil</a>
        <a href="tecnicas.php">Técnicas</a>
        <a href="treinos.php">Treinos</a>
    </nav>

    <div class="container">
        <h1>Técnicas</h1>
        <p>Aqui você pode assistir às técnicas e aprender mais sobre elas.</p>

        <!-- Exibindo as técnicas cadastradas -->
        <div class="tecnicas-lista">
            <?php foreach ($tecnicas as $tecnica): ?>
                <div class="tecnica-box">
                    <h2><?php echo htmlspecialchars($tecnica['titulo']); ?></h2>
                    <video controls>
                        <source src="uploads/<?php echo htmlspecialchars($tecnica['video_url']); ?>" type="video/mp4">
                        Seu navegador não suporta o elemento de vídeo.
                    </video>
                    <p><?php echo nl2br(htmlspecialchars($tecnica['descricao'])); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
