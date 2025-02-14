<?php
// Exibir erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Importar conexão com o banco de dados
require 'db.php';

$message = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username && $email && $password) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        try {
            $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)');
            $stmt->execute([$username, $email, $passwordHash]);

            $message = "Usuário registrado com sucesso!";
            $success = true;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Erro de chave duplicada
                $message = "Erro: Nome de usuário ou e-mail já cadastrado.";
            } else {
                $message = "Erro ao registrar usuário: " . $e->getMessage();
            }
        }
    } else {
        $message = "Por favor, preencha todos os campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .message-box {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .message-box h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .message-box p {
            font-size: 16px;
            margin-bottom: 20px;
            color: #555;
        }

        .message-box .success {
            color: green;
        }

        .message-box .error {
            color: red;
        }

        .message-box a {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            background-color: #2f2f2f;
            color: white;
            border-radius: 4px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .message-box a:hover {
            background-color: #444;
        }
    </style>
</head>
<body>
    <?php if ($message): ?>
        <div class="message-box">
            <h1><?php echo $success ? 'Sucesso!' : 'Aviso'; ?></h1>
            <p class="<?php echo $success ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </p>
            <?php if ($success): ?>
                <a href="index.html">Ir para Login</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</body>
</html>
