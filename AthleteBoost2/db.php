<?php
$host = 'localhost';
$dbname = 'athleteboost2';
$username = 'root'; // Substitua se necessário
$password = ''; // Substitua se necessário

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
