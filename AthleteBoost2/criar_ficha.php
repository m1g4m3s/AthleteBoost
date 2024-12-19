<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}

require 'db.php';

$user_id = $_SESSION['user_id'];

// Adicionar ficha
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titulo'])) {
    $titulo = $_POST['titulo'];
    $exercicios = $_POST['exercicios'];

    $stmt = $pdo->prepare('INSERT INTO fichas (user_id, titulo, exercicios) VALUES (?, ?, ?)');
    $stmt->execute([$user_id, $titulo, $exercicios]);

    header('Location: criar_ficha.php');
    exit;
}

// Buscar fichas do usuário
$stmt = $pdo->prepare('SELECT * FROM fichas WHERE user_id = ?');
$stmt->execute([$user_id]);
$fichas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Excluir ficha
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $ficha_id = $_GET['id'];

    $stmt = $pdo->prepare('DELETE FROM fichas WHERE id = ? AND user_id = ?');
    $stmt->execute([$ficha_id, $user_id]);

    header('Location: criar_ficha.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Ficha de Treino</title>
    <style>
        /* Estilos gerais */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
        }

        nav {
            background-color: #333;
            padding: 15px 0;
            text-align: center;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        nav a {
            color: white;
            margin: 0 20px;
            text-decoration: none;
            font-size: 18px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            margin-top: 80px;
            padding: 20px;
            text-align: center;
        }

        /* Formulário para criar ficha */
        form {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 500px;
            margin: 20px auto;
            text-align: left;
        }

        form input[type="text"],
        form textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        form button {
            width: 100%;
            padding: 12px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #444;
        }

        /* Fichas criadas */
        .fichas-lista {
            margin-top: 20px;
        }

        .ficha-box {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            width: 600px;
            position: relative;
            text-align: left;
        }

        .ficha-box h3 {
            font-size: 1.6rem;
            margin-bottom: 10px;
            color: #333;
        }

        .ficha-box p {
            font-size: 1rem;
            color: #666;
            margin: 5px 0;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            position: absolute;
            top: 20px;
            right: 20px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <nav>
        <a href="home.php">Home</a>
        <a href="perfil.php">Perfil</a>
        <a href="criar_ficha.php">Criar Ficha</a>
        <a href="treinos.php">Treinos</a>
        <a href="tecnicas.php">Técnicas</a>
        <a href="logout.php">Sair</a>
    </nav>

    <div class="container">
        <h1>Minhas Fichas de Treino</h1>

        <!-- Formulário para criar uma nova ficha -->
        <form action="criar_ficha.php" method="POST">
            <input type="text" name="titulo" placeholder="Título da Ficha" required>
            <textarea name="exercicios" placeholder="Exercícios e séries (ex.: Supino - 3x10)" required></textarea>
            <button type="submit">Criar Ficha</button>
        </form>

        <!-- Exibir fichas existentes -->
        <?php if (count($fichas) > 0): ?>
            <h2>Fichas Criadas</h2>
            <div class="fichas-lista">
                <?php foreach ($fichas as $ficha): ?>
                    <div class="ficha-box">
                        <h3><?php echo htmlspecialchars($ficha['titulo']); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars($ficha['exercicios'])); ?></p>
                        <a href="criar_ficha.php?action=delete&id=<?php echo $ficha['id']; ?>" class="btn-delete" onclick="return confirm('Deseja realmente excluir esta ficha?')">Excluir</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Você ainda não criou nenhuma ficha.</p>
        <?php endif; ?>
    </div>
</body>
</html>
