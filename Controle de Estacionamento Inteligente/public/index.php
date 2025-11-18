<?php
require __DIR__ . '/../vendor/autoload.php';
$dbFile = __DIR__ . '/../database/database.sqlite';
$pdo = new PDO('sqlite:' . $dbFile);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$rates = ['carro'=>5, 'moto'=>3, 'caminhao'=>10];
$sql = "
SELECT v.type, pr.entered_at, pr.exited_at
FROM parking_records pr
JOIN vehicles v ON v.id = pr.vehicle_id
WHERE pr.exited_at IS NOT NULL
";
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$summary = [];
foreach ($rows as $r) {
  $type = $r['type'];
  $entered = new DateTime($r['entered_at']);
  $exited = new DateTime($r['exited_at']);
  $hours = ceil(($exited->getTimestamp() - $entered->getTimestamp()) / 3600);
  $price = ($rates[$type] ?? 0) * $hours;
  if (!isset($summary[$type])) $summary[$type] = ['count'=>0,'revenue'=>0];
  $summary[$type]['count'] += 1;
  $summary[$type]['revenue'] += $price;
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Relatório Estacionamento</title></head>
<body>
<h1>Relatório</h1>
<table border="1" cellpadding="6" cellspacing="0">
  <tr><th>Tipo</th><th>Veículos</th><th>Faturamento (R$)</th></tr>
  <?php foreach ($summary as $type=>$s): ?>
    <tr>
      <td><?=htmlspecialchars($type)?></td>
      <td><?= $s['count'] ?></td>
      <td><?= number_format($s['revenue'],2,',','.') ?></td>
    </tr>
  <?php endforeach; ?>
</table>
</body>
</html>
