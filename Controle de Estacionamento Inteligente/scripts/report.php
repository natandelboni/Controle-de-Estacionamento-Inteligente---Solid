<?php
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
  $diffSec = $exited->getTimestamp() - $entered->getTimestamp();
  $hours = ceil($diffSec / 3600);
  $price = ($rates[$type] ?? 0) * $hours;
  if (!isset($summary[$type])) $summary[$type] = ['count'=>0,'revenue'=>0];
  $summary[$type]['count'] += 1;
  $summary[$type]['revenue'] += $price;
}

$totalVehicles = 0; $totalRevenue = 0;
echo "Relatório por tipo:\n";
foreach ($summary as $type => $s) {
  echo "- $type: veículos={$s['count']} faturamento=R$ " . number_format($s['revenue'],2,',','.') . "\n";
  $totalVehicles += $s['count'];
  $totalRevenue += $s['revenue'];
}
echo "Total veículos: $totalVehicles\n";
echo "Total faturamento: R$ " . number_format($totalRevenue,2,',','.') . "\n";
