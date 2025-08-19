<?php
require 'db.php';
$id = $_GET['id'];

$db->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
$db->prepare("DELETE FROM user_colors WHERE user_id = ?")->execute([$id]);

header('Location: index.php');
exit;