<?php
require 'db.php';
$id = $_GET['id'];

$user = $db->prepare("SELECT * FROM users WHERE id = ?");
$user->execute([$id]);
$user = $user->fetch(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $stmt = $db->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->execute([$name, $email, $id]);

    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<h2>Editar Usuário</h2>
<form method="POST">
    <div class="mb-3">
        <label>Nome:</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
    </div>
    <div class="mb-3">
        <label>Email:</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Atualizar</button>
    <a href="index.php" class="btn btn-secondary">Voltar</a>
</form>
</body>
</html>