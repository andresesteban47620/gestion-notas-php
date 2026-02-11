<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../helpers/functions.php";

$alumnos = $pdo->query("SELECT id, nombre, apellido FROM alumno ORDER BY apellido, nombre")->fetchAll();
$errores = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $alumno_id = (int)($_POST["alumno_id"] ?? 0);
  $nota = (float)($_POST["nota"] ?? -1);

  if ($alumno_id <= 0) $errores[] = "Selecciona un alumno.";
  if ($nota < 0 || $nota > 10) $errores[] = "La nota debe estar entre 0 y 10.";

  if (!$errores) {
    $stmt = $pdo->prepare("INSERT INTO nota(alumno_id, nota) VALUES(?,?)");
    $stmt->execute([$alumno_id, $nota]);
    header("Location: index.php"); exit;
  }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrar nota</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <h3>Registrar nota</h3>

  <?php if ($errores): ?>
    <div class="alert alert-danger">
      <?php foreach ($errores as $e) echo "<div>".h($e)."</div>"; ?>
    </div>
  <?php endif; ?>

  <form method="post" class="card p-3 shadow-sm">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Alumno</label>
        <select class="form-select" name="alumno_id" required>
          <option value="">-- Selecciona --</option>
          <?php foreach ($alumnos as $a): ?>
            <option value="<?= (int)$a["id"] ?>">
              <?= h($a["apellido"]." ".$a["nombre"]) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Nota (0 a 10)</label>
        <input type="number" step="0.01" min="0" max="10"
               class="form-control" name="nota" required>
      </div>
    </div>

    <div class="mt-3 d-flex gap-2">
      <button class="btn btn-success">Guardar</button>
      <a class="btn btn-secondary" href="index.php">Volver</a>
    </div>
  </form>
</div>
</body>
</html>
