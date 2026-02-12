<?php
require_once __DIR__ . "/../config/db.php";

$id = (int)($_GET["id"] ?? 0);
$del = $pdo->prepare("DELETE FROM alumno WHERE id=?");
$del->execute([$id]);

header("Location: index.php");
exit;
