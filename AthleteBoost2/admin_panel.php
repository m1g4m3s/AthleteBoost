<?php
session_start();

// Verificar se o usuário é administrador
if ($_SESSION['user_id'] !== 'admin') {
    header('Location: index.html');
    exit;
}

require 'db.php';

// Função para listar treinos, técnicas e usuários
function listarConteudo($pdo, $tipo) {
    $stmt = $pdo->prepare("SELECT * FROM $tipo");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Excluir treino, técnica ou usuário
if (isset($_GET['action']) && isset($_GET['id']) && isset($_GET['tipo'])) {
    $id = $_GET['id'];
    $tipo = $_GET['tipo'];

    // Verificar se o tipo de conteúdo existe na lista permitida
    if (in_array($tipo, ['treinos', 'tecnicas', 'users'])) {
        $stmt = $pdo->prepare("DELETE FROM $tipo WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: admin_panel.php");
        exit;
    } else {
        echo "Tipo inválido.";
    }
}

// Carregar treinos, técnicas e usuários
$treinos = listarConteudo($pdo, 'treinos');
$tecnicas = listarConteudo($pdo, 'tecnicas');
$usuarios = listarConteudo($pdo, 'users');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <a href="admin_panel.php">Painel Administrativo</a>
    <a href="logout.php">Sair</a>
</nav>

<div class="container">
    <h1>Painel Administrativo</h1>

    <!-- Seção de Usuários Cadastrados -->
    <section>
        <h2>Usuários Cadastrados</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo $usuario['id']; ?></td>
                        <td><?php echo $usuario['username']; ?></td>
                        <td><?php echo $usuario['email']; ?></td>
                        <td>
                            <a href="admin_panel.php?action=delete&id=<?php echo $usuario['id']; ?>&tipo=users" class="btn btn-delete" onclick="return confirm('Você tem certeza que deseja excluir este usuário?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- Seção de Gerenciamento de Treinos -->
    <section>
        <h2>Gerenciar Treinos</h2>
        <a href="add_treino.php" class="btn btn-add">Adicionar Novo Treino</a>
        <div class="treinos-list">
            <?php foreach ($treinos as $treino): ?>
                <div class="treino-box">
                    <h3><?php echo $treino['titulo']; ?></h3>
                    <video width="320" height="240" controls>
                        <source src="<?php echo htmlspecialchars($treino['video_url']); ?>" type="video/mp4">
                    </video>
                    <p><?php echo $treino['descricao']; ?></p>
                    <a href="admin_panel.php?action=delete&id=<?php echo $treino['id']; ?>&tipo=treinos" class="btn btn-delete" onclick="return confirm('Você tem certeza que deseja excluir este treino?')">Excluir</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Seção de Gerenciamento de Técnicas -->
    <section>
        <h2>Gerenciar Técnicas</h2>
        <a href="add_tecnica.php" class="btn btn-add">Adicionar Nova Técnica</a>
        <div class="tecnicas-list">
            <?php foreach ($tecnicas as $tecnica): ?>
                <div class="tecnica-box">
                    <h3><?php echo $tecnica['titulo']; ?></h3>
                    <video width="320" height="240" controls>
                        <source src="<?php echo htmlspecialchars($tecnica['video_url']); ?>" type="video/mp4">
                    </video>
                    <p><?php echo $tecnica['descricao']; ?></p>
                    <a href="admin_panel.php?action=delete&id=<?php echo $tecnica['id']; ?>&tipo=tecnicas" class="btn btn-delete" onclick="return confirm('Você tem certeza que deseja excluir esta técnica?')">Excluir</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>

</body>
</html>
