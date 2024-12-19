<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}

require 'db.php';

// Verifica se o ID da ficha foi passado na URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Deleta a ficha do banco
    $stmt = $pdo->prepare("DELETE FROM fichas_treino WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);

    header('Location: fichas.php');
    exit;
} else {
    echo "Ficha não encontrada!";
}
