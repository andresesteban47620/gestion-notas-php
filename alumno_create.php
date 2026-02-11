<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../helpers/functions.php";

$errores = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nombre = trim($_POST["nombre"] ?? "");
  $apellido = trim($_POST["apellido"] ?? "");
  $correo = trim($_POST["correo"] ?? "");

  if ($nombre === "" || $apellido === "" || $correo === "") $errores[] = "Completa todos los campos.";
  if ($correo !== "" && !filter_var($correo, FILTER_VALIDATE_EMAIL)) $errores[] = "Correo inválido.";

  if (!$errores) {
    try {
      $stmt = $pdo->prepare("INSERT INTO alumno(nombre, apellido, correo) VALUES(?,?,?)");
      $stmt->execute([$nombre, $apellido, $correo]);
      header("Location: index.php"); exit;
    } catch (Exception $e) {
      $errores[] = "Ese correo ya existe o ocurrió un error.";
    }
  }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrar alumno</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <h3>Registrar alumno</h3>

  <?php if ($errores): ?>
    <div class="alert alert-danger">
      <?php foreach ($errores as $e) echo "<div>".h($e)."</div>"; ?>
    </div>
  <?php endif; ?>

  <form method="post" class="card p-3 shadow-sm">
    <div class="row g-3">
      <div class="col-md-4">
        <label class="form-label">Nombre</label>
        <input class="form-control" name="nombre" value="<?= h($_POST["nombre"] ?? "") ?>" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Apellido</label>
        <input class="form-control" name="apellido" value="<?= h($_POST["apellido"] ?? "") ?>" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Correo</label>
        <input class="form-control" name="correo" value="<?= h($_POST["correo"] ?? "") ?>" required>
      </div>
    </div>

    <div class="mt-3 d-flex gap-2">
      <button class="btn btn-primary">Guardar</button>
      <a class="btn btn-secondary" href="index.php">Volver</a>
    </div>
  </form>
</div>
</body>
</html>
