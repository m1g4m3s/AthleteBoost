<?php
// Exibir erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Importar conexão com o banco de dados
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username && $email && $password) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        try {
            $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)');
            $stmt->execute([$username, $email, $passwordHash]);

            echo "Usuário registrado com sucesso!";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Erro de chave duplicada
                echo "Erro: Nome de usuário ou e-mail já cadastrado.";
            } else {
                echo "Erro ao registrar usuário: " . $e->getMessage();
            }
        }
    } else {
        echo "Por favor, preencha todos os campos.";
    }
}
?>
