<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}

require 'db.php';

// Buscar as fichas do usuário
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM fichas_treino WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$fichas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Fichas de Treino</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <a href="home.php">Home</a>
    <a href="perfil.php">Perfil</a>
    <a href="editar_perfil.php">Editar Perfil</a>
    <a href="fichas.php">Minhas Fichas</a>
</nav>

<div class="container">
    <h1>Minhas Fichas de Treino</h1>

    <?php if (count($fichas) > 0): ?>
        <div class="fichas-lista">
            <?php foreach ($fichas as $ficha): ?>
                <div class="ficha-box">
                    <h2><?php echo htmlspecialchars($ficha['titulo']); ?></h2>
                    <p><strong>Exercícios:</strong></p>
                    <pre><?php echo nl2br(htmlspecialchars($ficha['exercicios'])); ?></pre>
                    <a href="excluir_ficha.php?id=<?php echo $ficha['id']; ?>" class="btn btn-delete" onclick="return confirm('Você tem certeza que deseja excluir esta ficha?')">Excluir</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Você ainda não tem fichas de treino criadas.</p>
    <?php endif; ?>
</div>

</body>
</html>
