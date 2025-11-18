<?php
$dbFile = __DIR__ . '/../database/database.sqlite';
$pdo = new PDO('sqlite:' . $dbFile);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pdo->exec("INSERT INTO vehicles (plate, type) VALUES ('ABC1234','carro'),('MOTO12','moto'),('TRK999','caminhao')");

$pdo->exec("INSERT INTO parking_records (vehicle_id, entered_at, exited_at) VALUES 
(1, datetime('now','-3 hours'), datetime('now','-1 hours')),
(2, datetime('now','-4 hours'), datetime('now','-1 hours','+30 minutes')),
(3, datetime('now','-2 hours'), datetime('now','-1 hours'))");
echo "Seed aplicado\n";
