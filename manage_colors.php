<?php
require 'db.php';
$id = $_GET['id'];

$colors = $db->query("SELECT * FROM colors")->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->prepare("SELECT color_id FROM user_colors WHERE user_id = ?");
$stmt->execute([$id]);
$user_colors = $stmt->fetchAll(PDO::FETCH_COLUMN);

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected = $_POST['colors'] ?? [];

    $db->prepare("DELETE FROM user_colors WHERE user_id = ?")->execute([$id]);

    $stmt = $db->prepare("INSERT INTO user_colors (user_id, color_id) VALUES (?, ?)");
    foreach($selected as $color_id) {
        $stmt->execute([$id, $color_id]);
    }

    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gerenciar Cores</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
<h2>Gerenciar Cores</h2>
<form method="POST">
    <?php foreach($colors as $color): ?>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="colors[]" value="<?= $color['id'] ?>" <?= in_array($color['id'], $user_colors) ? 'checked' : '' ?>>
            <label class="form-check-label"><?= htmlspecialchars($color['name']) ?></label>
        </div>
    <?php endforeach; ?>
    <button type="submit" class="btn btn-warning mt-3">Salvar Cores</button>
    <a href="index.php" class="btn btn-secondary mt-3">Voltar</a>
</form>
</body>
</html>