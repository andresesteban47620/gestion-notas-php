<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../helpers/functions.php";

$rows = $pdo->query("
  SELECT n.id, n.nota, n.creado_en,
         a.id AS alumno_id, a.nombre, a.apellido
  FROM nota n
  INNER JOIN alumno a ON a.id = n.alumno_id
  ORDER BY a.apellido, a.nombre, n.creado_en DESC
")->fetchAll();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestionar notas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Gestionar notas</h3>
    <div class="d-flex gap-2">
      <a class="btn btn-success" href="nota_create.php">+ Registrar nota</a>
      <a class="btn btn-secondary" href="index.php">Volver</a>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-body table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Alumno</th>
            <th>Nota</th>
            <th>Fecha</th>
            <th class="text-end">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r): ?>
            <tr>
              <td><?= h($r["apellido"] . " " . $r["nombre"]) ?></td>
              <td><span class="badge text-bg-secondary"><?= number_format((float)$r["nota"], 2) ?></span></td>
              <td><?= h($r["creado_en"]) ?></td>
              <td class="text-end">
                <a class="btn btn-sm btn-outline-primary" href="nota_edit.php?id=<?= (int)$r["id"] ?>">Editar</a>
                <a class="btn btn-sm btn-outline-danger"
                   href="nota_delete.php?id=<?= (int)$r["id"] ?>"
                   onclick="return confirm('¿Eliminar esta nota?')">Eliminar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
