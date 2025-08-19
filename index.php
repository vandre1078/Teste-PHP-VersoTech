<?php
require 'db.php';

$users = $db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD PHP SQLite</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<h1>Lista de Usuários</h1>
<a href="create.php" class="btn btn-success mb-3">Adicionar Usuário</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Cores</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($users as $user): ?>
            <?php
                $stmt = $db->prepare("SELECT c.name FROM colors c 
                                      JOIN user_colors uc ON c.id = uc.color_id 
                                      WHERE uc.user_id = ?");
                $stmt->execute([$user['id']]);
                $colors = $stmt->fetchAll(PDO::FETCH_COLUMN);
            ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= implode(', ', $colors) ?></td>
                <td>
                    <a href="edit.php?id=<?= $user['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                    <a href="delete.php?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm">Excluir</a>
                    <a href="manage_colors.php?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">Cores</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>