<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../helpers/functions.php";

$id = (int)($_GET["id"] ?? 0);

$stmt = $pdo->prepare("
  SELECT n.*, a.apellido, a.nombre
  FROM nota n
  INNER JOIN alumno a ON a.id = n.alumno_id
  WHERE n.id=?
");
$stmt->execute([$id]);
$notaRow = $stmt->fetch();
if (!$notaRow) die("Nota no encontrada.");

$errores = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nota = (float)($_POST["nota"] ?? -1);

  if ($nota < 0 || $nota > 10) $errores[] = "La nota debe estar entre 0 y 10.";

  if (!$errores) {
    $up = $pdo->prepare("UPDATE nota SET nota=? WHERE id=?");
    $up->execute([$nota, $id]);
    header("Location: notas.php"); exit;
  }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar nota</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <h3>Editar nota</h3>
  <div class="text-muted mb-3">Alumno: <?= h($notaRow["apellido"]." ".$notaRow["nombre"]) ?></div>

  <?php if ($errores): ?>
    <div class="alert alert-danger">
      <?php foreach ($errores as $e) echo "<div>".h($e)."</div>"; ?>
    </div>
  <?php endif; ?>

  <form method="post" class="card p-3 shadow-sm">
    <div class="mb-3">
      <label class="form-label">Nota (0 a 10)</label>
      <input type="number" step="0.01" min="0" max="10"
             class="form-control" name="nota"
             value="<?= h($_POST["nota"] ?? $notaRow["nota"]) ?>" required>
    </div>
    <div class="d-flex gap-2">
      <button class="btn btn-primary">Actualizar</button>
      <a class="btn btn-secondary" href="notas.php">Volver</a>
    </div>
  </form>
</div>
</body>
</html>
