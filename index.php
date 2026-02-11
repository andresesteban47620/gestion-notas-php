<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../helpers/functions.php";

// Alumnos con promedio
$alumnos = $pdo->query("
  SELECT a.*,
         ROUND(AVG(n.nota), 2) AS promedio
  FROM alumno a
  LEFT JOIN nota n ON n.alumno_id = a.id
  GROUP BY a.id
  ORDER BY a.apellido, a.nombre
")->fetchAll();

// Notas por alumno (para mostrarlas como etiquetas)
$notas = $pdo->query("SELECT alumno_id, nota FROM nota ORDER BY creado_en DESC")->fetchAll();
$mapNotas = [];
foreach ($notas as $n) {
  $mapNotas[$n["alumno_id"]][] = $n["nota"];
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestión de Notas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Alumnos y Notas</h3>
    <div class="d-flex gap-2">
      <a class="btn btn-outline-dark" href="notas.php">Gestionar notas</a>
      <a class="btn btn-primary" href="alumno_create.php">+ Registrar alumno</a>
      <a class="btn btn-success" href="nota_create.php">+ Registrar nota</a>
      <a class="btn btn-danger" href="reporte_pdf.php" target="_blank">PDF</a>
      <a class="btn btn-success" href="reporte_excel.php">Excel</a>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-body table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Alumno</th>
            <th>Correo</th>
            <th>Notas</th>
            <th>Promedio</th>
            <th>Resultado</th>
            <th class="text-end">Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($alumnos as $a):
          $listaNotas = $mapNotas[$a["id"]] ?? [];
          $prom = $a["promedio"] !== null ? (float)$a["promedio"] : 0.00;
          $resultado = $a["promedio"] !== null ? resultadoCualitativo($prom) : "-";
        ?>
          <tr>
            <td><?= h($a["apellido"] . " " . $a["nombre"]) ?></td>
            <td><?= h($a["correo"]) ?></td>
            <td>
              <?php if (!$listaNotas): ?>
                <span class="text-muted">Sin notas</span>
              <?php else: ?>
                <?php foreach ($listaNotas as $nota): ?>
                  <span class="badge text-bg-secondary me-1">
                    <?= number_format((float)$nota, 2) ?>
                  </span>
                <?php endforeach; ?>
              <?php endif; ?>
            </td>
            <td><?= number_format($prom, 2) ?></td>
            <td><?= h($resultado) ?></td>
            <td class="text-end">
              <a class="btn btn-sm btn-outline-primary" href="alumno_edit.php?id=<?= (int)$a["id"] ?>">Editar</a>
              <a class="btn btn-sm btn-outline-danger"
                 href="alumno_delete.php?id=<?= (int)$a["id"] ?>"
                 onclick="return confirm('¿Eliminar alumno y sus notas?')">Eliminar</a>
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


