// login.php
<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        try {
            if ($username === 'admin' && $password === '123') {
                session_start();
                $_SESSION['user_id'] = 'admin';
                header('Location: admin_panel.php');
                exit;
            } else {
                $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
                $stmt->execute([$username]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['password_hash'])) {
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    header('Location: home.php');
                    exit;
                } else {
                    echo "Usuário ou senha inválidos.";
                }
            }
        } catch (PDOException $e) {
            echo "Erro ao realizar login: " . $e->getMessage();
        }
    } else {
        echo "Por favor, preencha todos os campos.";
    }
}
?>
