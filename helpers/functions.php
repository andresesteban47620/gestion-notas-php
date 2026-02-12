<?php
function resultadoCualitativo(float $promedio): string {
  if ($promedio < 5) return "Suspenso";
  if ($promedio < 7) return "Bien";
  if ($promedio < 9) return "Notable";
  return "Sobresaliente";
}

function h($s) { return htmlspecialchars($s ?? "", ENT_QUOTES, "UTF-8"); }
