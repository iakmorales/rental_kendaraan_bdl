<?php

require_once 'config/database.php';
require_once 'models/kendaraanModel.php';
require_once 'models/tipeKendaraanModel.php';
require_once 'models/sopirModel.php';
require_once 'models/pelangganModel.php';
require_once 'models/rentalModel.php';
require_once 'models/pengembalianModel.php';

$database = new Database();
$db = $database->getConnection();
$kendaraanModel = new KendaraanModel($db);
$tipeKendaraanModel = new TipeKendaraanModel($db);
$sopirModel = new SopirModel($db);
$pelangganModel = new PelangganModel($db);
$rentalModel = new RentalModel($db);
$pengembalianModel = new PengembalianModel($db);

?>