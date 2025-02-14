<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}

// Conexão com o banco de dados
require 'db.php';

// Buscar os treinos cadastrados no banco de dados
$query = "SELECT * FROM treinos";
$stmt = $pdo->prepare($query);
$stmt->execute();
$treinos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Treinos</title>
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
        <h1>Treinos</h1>
        <p>Aqui você pode acompanhar e personalizar seus treinos para alcançar seus objetivos.</p>

        <!-- Exibindo os treinos cadastrados -->
        <div class="treinos-lista">
            <?php foreach ($treinos as $treino): ?>
                <div class="treino-box">
                    <h2><?php echo htmlspecialchars($treino['titulo']); ?></h2>
                    <video controls>
                        <source src="uploads/<?php echo htmlspecialchars($treino['video']); ?>" type="video/mp4">
                        Seu navegador não suporta o elemento de vídeo.
                    </video>
                    <p><?php echo nl2br(htmlspecialchars($treino['descricao'])); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
